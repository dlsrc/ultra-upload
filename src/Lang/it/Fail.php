<?php declare(strict_types=1);
/**
 * (c) 2005-2025 Dmitry Lebedev <dl@adios.ru>
 * This source code is part of the Ultra upload package.
 * Please see the LICENSE file for copyright and licensing information.
 */
namespace Ultra\Upload\Lang\it;

use Ultra\Getter;

final class Fail extends Getter {
	protected function initialize(): void {
		$this->_property['e_ini_size']  = 'Il file ricevuto "{0}" supera la dimensione massima consentita.';
		$this->_property['e_form_size'] = 'La dimensione del file caricato "{0}" ha superato il valore MAX_FILE_SIZE.';
		$this->_property['e_partial']   = 'Il file "{0}" non è stato caricato completamente.';
		$this->_property['e_no_file']   = 'Il file non è stato caricato.';
		$this->_property['e_files']     = 'L\'indice "{0}" nell\'array $_FILES non è definito.';
		$this->_property['e_move']      = 'Impossibile spostare il file scaricato "{0}".';
		$this->_property['e_ext']       = 'Estensione "{1}" non valida del file di origine "{0}".';
		$this->_property['e_mime']      = 'Tipo "{1}" non valido del file caricato "{0}".';
		$this->_property['e_max']       = 'La dimensione massima del file è stata superata.';
		$this->_property['e_min']       = 'La dimensione minima del file è stata superata.';
		$this->_property['e_unknown']   = 'Errore sconosciuto durante il caricamento del file "{0}".';
	}
}
