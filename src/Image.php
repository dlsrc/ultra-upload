<?php declare(strict_types=1);
/**
 * (c) 2005-2024 Dmitry Lebedev <dl@adios.ru>
 * This source code is part of the Ultra upload package.
 * Please see the LICENSE file for copyright and licensing information.
 */
namespace Ultra\Upload;

final class Image extends Moving {
	protected function allow(): array {
		return [
			'image/gif'  => ['gif'],
			'image/jpeg' => ['jpg', 'jpeg'],
			'image/png'  => ['png'],
		];
	}
}
