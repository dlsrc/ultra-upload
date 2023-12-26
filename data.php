<?php declare(strict_types=1);
/**
 * (c) 2005-2023 Dmitry Lebedev <dl@adios.ru>
 * This source code is part of the Ultra upload package.
 * Please see the LICENSE file for copyright and licensing information.
 */
namespace ultra\upload;

enum DataType {
	case File;
	case Image;

	public function getClass(): string {
		return match($this) {
			self::File  => File::class,
			self::Image => Image::class,
		};
	}
}

final class Data {
	private array $file;
	private array $error;
	private string $type;

	public function __construct(string $event, DataType $type = DataType::File) {
		$this->receive($event, $type);
	}

	protected function clean(DataType $type): void {
		$this->file  = [];
		$this->error = [];
		$this->type  = $type->getClass();
	}

	public function isError(): int {
		return \count($this->error);
	}

	public function isSend(): bool {
		if (!empty($this->error)) {
			if (Code::Files == $this->error[0]->type) {
				return false;
			}
		}

		return true;
	}

	public function isFiles(): bool {
		if (!empty($this->error)) {
			if (Code::NoFile == $this->error[0]->type) {
				return false;
			}
		}

		return true;
	}

	public function errno(int $id = 0): int {
		if (isset($this->error[$id])) {
			return $this->error[$id]->type->value;
		}

		return 0;
	}

	public function error(bool $div = false): string {
		if (empty($this->error)) {
			return '';
		}

		$mesg = [];

		if (!$div) {
			$div = ' ';
		}

		foreach ($this->error as $error) {
			$mesg[] = $error->message;
		}

		return \implode($div, $mesg);
	}

	public function loaded(): int {
		return \count($this->file);
	}

	public function file(int $id = 0): Moving|null {
		if (isset($this->file[$id])) {
			return $this->file[$id];
		}

		return null;
	}

	public function receive(string $event, DataType $type = DataType::File): void {
		$this->clean($type);

		if (!isset($_FILES[$event])) {
			$this->error[] = new Fail(Code::Files, Fail::message('e_files', $event));
			return;
		}

		if (\is_array($_FILES[$event]['name'])) {
			foreach (\array_keys($_FILES[$event]['name']) as $key) {
				if (\UPLOAD_ERR_OK == $_FILES[$event]['error'][$key]) {
					$this->file[] = new $this->type(
						$_FILES[$event]['name'][$key],
						$_FILES[$event]['type'][$key],
						$_FILES[$event]['tmp_name'][$key],
						$_FILES[$event]['size'][$key],
						$key
					);
				}
				else {
					$this->setError($event, $key);
				}
			}
		}
		else {
			if (\UPLOAD_ERR_OK == $_FILES[$event]['error']) {
				$this->file[] = new $this->type(
					$_FILES[$event]['name'],
					$_FILES[$event]['type'],
					$_FILES[$event]['tmp_name'],
					$_FILES[$event]['size']
				);
			}
			else {
				$this->setError($event);
			}
		}
	}

	private function setError(string $event, int|null $key = null): void {
		if (isset($key)) {
			$error = $_FILES[$event]['error'][$key];
			$name = $_FILES[$event]['name'][$key];
		}
		elseif (isset($_FILES[$event]['error'])) {
			$error = $_FILES[$event]['error'];
			$name = $_FILES[$event]['name'];
		}
		else {
			$error = \UPLOAD_ERR_NO_FILE;
			$name = '';
		}

		$this->error[] = match ($error) {
			\UPLOAD_ERR_INI_SIZE  => new Fail(Code::IniSize, Fail::message('e_ini_size', $name)),
			\UPLOAD_ERR_FORM_SIZE => new Fail(Code::FormSize, Fail::message('e_form_size', $name)),
			\UPLOAD_ERR_PARTIAL   => new Fail(Code::Partial, Fail::message('e_partial', $name)),
			\UPLOAD_ERR_NO_FILE   => new Fail(Code::NoFile, Fail::message('e_no_file')),
			\default              => new Fail(Code::Unknown, Fail::message('e_unknown', $name)),
		};
	}

	public function addError(Moving $up): void {
		if ($error = $up->getError()) {
			$this->error[] = $error;
		}
	}

	public function total(): int {
		$size = 0;

		foreach ($this->file as $file) {
			$size+= $file->getSize();
		}

		return $size;
	}
}
