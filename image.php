<?php declare(strict_types=1);
/**
 * (c) 2005-2023 Dmitry Lebedev <dl@adios.ru>
 * This source code is part of the Ultra upload package.
 * Please see the LICENSE file for copyright and licensing information.
 */
namespace ultra\upload;

final class Image extends Moving {
	protected function allow(): array {
		return [
			'image/gif'  => ['gif'],
			'image/jpeg' => ['jpg', 'jpeg'],
			'image/png'  => ['png'],
		];
	}
}
