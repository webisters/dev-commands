<?php declare(strict_types=1);
/*
 * This file is part of Webisters Dev Commands Library.
 *
 * (c) Hafiz Muhammad Moaz <thewebisters@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Tests\CLI\Commands\Seeds;

use Framework\Database\Extra\Seeder;

class PostsSeeder extends Seeder
{
    public function run() : void
    {
        \usleep(1000);
    }
}
