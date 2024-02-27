<?php declare(strict_types=1);
/**
 * (c) 2005-2024 Dmitry Lebedev <dl@adios.ru>
 * This source code is part of the Ultra upload package.
 * Please see the LICENSE file for copyright and licensing information.
 */
namespace Ultra\Upload\Lang\ru;

use Ultra\Getter;

final class Fail extends Getter {
	protected function initialize(): void {
		$this->_property['e_ini_size']  = 'Размер принятого файла "{0}" превысил максимально допустимый размер.';
		$this->_property['e_form_size'] = 'Размер загружаемого файла "{0}" превысил значение MAX_FILE_SIZE.';
		$this->_property['e_partial']   = 'Файл "{0}" загружен не полностью.';
		$this->_property['e_no_file']   = 'Файл не загружен.';
		$this->_property['e_files']     = 'Индекс "{0}" в массиве $_FILES не определен.';
		$this->_property['e_move']      = 'Не удается переместить загруженный файл "{0}".';
		$this->_property['e_ext']       = 'Недопустимое расширение "{0}" исходного файла.';
		$this->_property['e_mime']      = 'Неверный тип "{1}" загруженного файла "{0}".';
		$this->_property['e_max']       = 'Превышен максимальный размер файла.';
		$this->_property['e_min']       = 'Превышен минимальный размер файла.';
		$this->_property['e_unknown']   = 'Неизвестная ошибка при загрузке файла "{0}".';
	}
}
