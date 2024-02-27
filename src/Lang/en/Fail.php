<?php declare(strict_types=1);
/**
 * (c) 2005-2024 Dmitry Lebedev <dl@adios.ru>
 * This source code is part of the Ultra upload package.
 * Please see the LICENSE file for copyright and licensing information.
 */
namespace Ultra\Upload\Lang\en;

use Ultra\Getter;

final class Fail extends Getter {
	protected function initialize(): void {
		$this->_property['e_ini_size']  = 'The received file "{0}" exceeds the maximum size allowed.';
		$this->_property['e_form_size'] = 'The size of the uploaded file "{0}" exceeded the MAX_FILE_SIZE value.';
		$this->_property['e_partial']   = 'The file "{0}" was not fully loaded.';
		$this->_property['e_no_file']   = 'File was not loaded.';
		$this->_property['e_files']     = 'The index "{0}" in the $_FILES array is not defined.';
		$this->_property['e_move']      = 'Unable to move downloaded file "{0}".';
		$this->_property['e_ext']       = 'Invalid extension "{1}" of source file "{0}".';
		$this->_property['e_mime']      = 'Invalid type "{1}" of uploaded file "{0}".';
		$this->_property['e_max']       = 'The maximum file size has been exceeded.';
		$this->_property['e_min']       = 'The minimum file size has been exceeded.';
		$this->_property['e_unknown']   = 'Unknown error loading file "{0}".';
	}
}
