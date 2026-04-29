<?php declare(strict_types=1);
/*
 * This file is part of Webisters Dev Commands Library.
 *
 * (c) Hafiz Muhammad Moaz <thewebisters@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Tests\CLI\Commands;

use Framework\CLI\Commands\Start;
use Framework\CLI\Console;

/**
 * Class StartTest.
 */
final class StartTest extends \PHPUnit\Framework\TestCase
{
    public function testResolvePort() : void
    {
        $command = new class(new Console()) extends Start {
            public function testResolvePort(?string $port) : ?int
            {
                return $this->resolvePort($port);
            }
        };

        self::assertSame(8000, $command->testResolvePort(null));
        self::assertSame(8000, $command->testResolvePort(''));
        self::assertSame(8080, $command->testResolvePort('8080'));
        self::assertNull($command->testResolvePort('foo'));
        self::assertNull($command->testResolvePort('0'));
        self::assertNull($command->testResolvePort('70000'));
    }

    public function testBuildServerCommandUsesDocumentRootAndRouter() : void
    {
        $command = new class(new Console()) extends Start {
            public function testBuildServerCommand(int $port, string $documentRoot, ?string $routerScript) : string
            {
                return $this->buildServerCommand($port, $documentRoot, $routerScript);
            }
        };

        $actual = $command->testBuildServerCommand(8000, '/tmp/public', '/tmp/public/index.php');

        self::assertStringContainsString(' -S 127.0.0.1:8000', $actual);
        self::assertStringContainsString(' -t ', $actual);
        self::assertStringContainsString('/tmp/public', $actual);
        self::assertStringContainsString('/tmp/public/index.php', $actual);
    }

    public function testResolveDocumentRootAndRouterScript() : void
    {
        $command = new class(new Console()) extends Start {
            public function testResolveDocumentRoot(string $cwd) : string
            {
                return $this->resolveDocumentRoot($cwd);
            }

            public function testResolveRouterScript(string $documentRoot) : ?string
            {
                return $this->resolveRouterScript($documentRoot);
            }
        };

        $base = \sys_get_temp_dir() . '/webisters-start-' . \uniqid('', true);
        $public = $base . '/public';

        \mkdir($public, 0755, true);
        \file_put_contents($public . '/index.php', '<?php');

        $documentRoot = $command->testResolveDocumentRoot($base);
        $routerScript = $command->testResolveRouterScript($documentRoot);

        self::assertSame(\realpath($public), $documentRoot);
        self::assertSame(\realpath($public . '/index.php'), $routerScript);

        @\unlink($public . '/index.php');
        @\rmdir($public);
        @\rmdir($base);
    }
}
