<?php declare(strict_types=1);
/**
 * (c) 2005-2023 Dmitry Lebedev <dl@adios.ru>
 * This source code is part of the Ultra upload package.
 * Please see the LICENSE file for copyright and licensing information.
 */
namespace ultra\upload;

enum Code: int implements \ultra\Condition {
	case Unknown   = 400; // Неизвестная ошибка
	case IniSize   = 401; // Размер принятого файла превысил максимально допустимый размер
	case FormSize  = 402; // Размер загружаемого файла превысил значение MAX_FILE_SIZE
	case Partial   = 403; // Файл загружен не полностью
	case NoFile    = 404; // Файл не загружен
	case Files     = 406; // Индекс в массиве $_FILES не определен
	case Move      = 405; // Не удается переместить загруженный файл
	case Ext       = 407; // Неверное расширение исходного файла
	case Mime      = 408; // Неверный тип файла
	case Max       = 409; // Превышен максимальный размер файла
	case Min       = 410; // Превыщен минимальный размер файла

	public function isFatal(): bool {
		return false;
	}
}
