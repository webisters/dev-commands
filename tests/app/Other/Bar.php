<?php declare(strict_types=1);
/*
 * This file is part of Webisters Dev Commands Library.
 *
 * (c) Hafiz Muhammad Moaz <thewebisters@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Tests\CLI\Commands\app\Other;

use Framework\MVC\Controller;
use Framework\Routing\Attributes\RouteNotFound;

class Bar extends Controller
{
    #[RouteNotFound]
    public function notFound() : void
    {
    }
}
