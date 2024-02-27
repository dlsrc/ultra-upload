<?php declare(strict_types=1);
/**
 * (c) 2005-2024 Dmitry Lebedev <dl@adios.ru>
 * This source code is part of the Ultra upload package.
 * Please see the LICENSE file for copyright and licensing information.
 */
namespace Ultra\Upload;

use Ultra\Fail as Bad;
use Ultra\Generic\Informer;
use Ultra\Generic\Sociable;

final class Fail extends Bad implements Sociable {
	use Informer;
}
