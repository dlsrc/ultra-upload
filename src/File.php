<?php declare(strict_types=1);
/**
 * (c) 2005-2025 Dmitry Lebedev <dlsrc.extra@gmail.com>
 * This source code is part of the Ultra upload package.
 * Please see the LICENSE file for copyright and licensing information.
 */
namespace Ultra\Upload;

final class File extends Moving {
	protected function allow(): array {
		return [];
	}
}
