<?php
/*
 * This file is part of Webisters Dev Commands Library.
 *
 * (c) Hafiz Muhammad Moaz <thewebisters@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use Framework\CodingStandard\Config;
use Framework\CodingStandard\Finder;

return (new Config())->setDefaultHeaderComment(
    'Webisters Dev Commands Library',
    'Hafiz Muhammad Moaz <thewebisters@gmail.com>'
)->setFinder(
    Finder::create()->in(__DIR__)
);
