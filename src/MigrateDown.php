<?php declare(strict_types=1);
/*
 * This file is part of Webisters Dev Commands Library.
 *
 * (c) Hafiz Muhammad Moaz <thewebisters@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Framework\CLI\Commands;

/**
 * Class MigrateDown.
 *
 * @package dev-commands
 */
class MigrateDown extends AbstractMigration
{
    protected string $description = 'Runs migrations down.';

    public function run() : void
    {
        $this->runMigration('down');
    }
}
