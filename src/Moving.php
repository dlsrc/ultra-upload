<?php declare(strict_types=1);
/**
 * (c) 2005-2025 Dmitry Lebedev <dl@adios.ru>
 * This source code is part of the Ultra upload package.
 * Please see the LICENSE file for copyright and licensing information.
 */
namespace Ultra\Upload;

use finfo;
use Ultra\IO;
use Ultra\State;
use Ultra\Chars\Translit;

abstract class Moving {
	abstract protected function allow(): array;

	private int $key;
	private string $name;
	private string $file;
	private string $ext;
	private string $type;
	private string $path;
	private int $size;
	private Fail|null $error;
	private bool $moved;

	public function __construct(string $name, string $type, string $temp, int $size, int $key = 0) {
		$inf = pathinfo($name);

		$this->key   = $key;
		$this->name  = $name;
		$this->file  = $inf['filename'];
		$this->ext   = $inf['extension'];
		$this->type  = $type;
		$this->path  = $temp;
		$this->size  = $size;
		$this->error = null;
		$this->moved = false;
		$this->check();
	}

	public function check(): void {
		$allow = $this->allow();

		if (empty($allow)) {
			return;
		}

		$inf = new finfo(FILEINFO_MIME_TYPE);
		$this->type = $inf->file($this->path);

		if (!isset($allow[$this->type])) {
			$this->error = new Fail(Code::Mime, Fail::message('e_mime', $this->name, $this->type));
			return;
		}

		$ext = $allow[$this->type];

		if (empty($ext)) {
			return;
		}

		if (!in_array($this->ext, $ext)) {
			$this->ext  = array_shift($ext);
			$this->name = $this->file.'.'.$this->ext;
		}
	}

	public function isError(): bool {
		if (null == $this->error) {
			return false;
		}

		return true;
	}

	public function getError(): State|null {
		return $this->error;
	}

	public function errno(): int {
		if (null == $this->error) {
			return 0;
		}

		return $this->error->type->value;
	}

	public function error(): string {
		if (null == $this->error) {
			return '';
		}

		return $this->error->message;
	}

	public function move(string $file): bool {
		if ($this->moved) {
			return true;
		}

		if ($this->isError()) {
			return false;
		}

		if (!IO::indir($file)) {
			return false;
		}

		if (!move_uploaded_file($this->path, $file)) {
			$this->error = new Fail(Code::Move, Fail::message('e_move', $this->name));
			return false;
		}
		else {
			chmod($file, IO::fm());
			$this->path = $file;
			$this->moved = true;
		}

		return true;
	}

	public function username(bool $trans = false): string {
		if ($trans) {
			return Translit::ru2en($this->name);
		}

		return $this->name;
	}

	public function filename(bool $trans = false): string {
		if ($trans) {
			return Translit::ru2en($this->file);
		}

		return $this->file;
	}

	public function ext(): string {
		return '.'.$this->ext;
	}

	public function name():string {
		return $this->name;
	}

	public function hash(): string {
		return md5_file($this->path);
	}

	public function getSize(): int {
		return $this->size;
	}

	public function getSizeAsString(): string {
		$size = ['b', 'Kb', 'Mb', 'Gb', 'Tb'];
		$string = $this->size;

		for ($i = 0; $i < 5; $i++) {
			if ($string > 1024) {
				$string = $string / 1024;
			}
			else {
				break;
			}
		}

		if ($i > 0) {
			$string = round($string, 2);
		}

		return $string.$size[$i];
	}

	public function mime() {
		return $this->type;
	}
}
