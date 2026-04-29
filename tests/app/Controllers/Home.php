<?php declare(strict_types=1);
/*
 * This file is part of Webisters Dev Commands Library.
 *
 * (c) Hafiz Muhammad Moaz <thewebisters@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Tests\CLI\Commands\app\Controllers;

use Framework\MVC\Controller;
use Framework\Routing\Attributes\Origin;
use Framework\Routing\Attributes\Route;

#[Origin('https://domain.tld')]
class Home extends Controller
{
    #[Route('GET', '/', name: 'home')]
    public function index() : void
    {
    }

    #[Route(['GET', 'POST'], '/contact')]
    public function contact() : void
    {
    }
}
