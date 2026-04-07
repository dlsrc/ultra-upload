<?php declare(strict_types=1);
/**
 * (c) 2005-2025 Dmitry Lebedev <dlsrc.extra@gmail.com>
 * This source code is part of the Ultra upload package.
 * Please see the LICENSE file for copyright and licensing information.
 */
namespace Ultra\Upload;

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
