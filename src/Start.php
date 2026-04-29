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

use Framework\CLI\CLI;
use Framework\CLI\Command;

/**
 * Class Start.
 *
 * @package dev-commands
 */
class Start extends Command
{
    protected string $name = 'start';
    protected string $description = 'Starts the app using the built-in PHP server.';
    protected string $usage = 'start [port]';
    protected string $group = 'HTTP';

    public function run() : void
    {
        $port = $this->resolvePort($this->console->getArgument(0));
        if ($port === null) {
            CLI::error('Invalid port. Use an integer between 1 and 65535.', null);
            return;
        }

        $cwd = (string) \getcwd();
        $documentRoot = $this->resolveDocumentRoot($cwd);
        $routerScript = $this->resolveRouterScript($documentRoot);

        CLI::newLine();
        CLI::success('Starting Server');
        CLI::newLine();
        CLI::success('http://127.0.0.1:' . $port);
        CLI::newLine();

        $command = $this->buildServerCommand($port, $documentRoot, $routerScript);
        $exitCode = $this->executeServer($command);

        if ($exitCode !== 0) {
            CLI::error('Server exited with code ' . $exitCode, null);
        }
    }

    protected function resolvePort(?string $port) : ?int
    {
        if ($port === null || \trim($port) === '') {
            return 8000;
        }

        if (!\ctype_digit($port)) {
            return null;
        }

        $resolvedPort = (int) $port;
        if ($resolvedPort < 1 || $resolvedPort > 65535) {
            return null;
        }

        return $resolvedPort;
    }

    protected function resolveDocumentRoot(string $cwd) : string
    {
        $public = $cwd . \DIRECTORY_SEPARATOR . 'public';
        if (\is_dir($public)) {
            return $this->normalizePath($public);
        }

        return $this->normalizePath($cwd);
    }

    protected function resolveRouterScript(string $documentRoot) : ?string
    {
        $index = $documentRoot . \DIRECTORY_SEPARATOR . 'index.php';
        if (\is_file($index)) {
            return $this->normalizePath($index);
        }

        return null;
    }

    protected function buildServerCommand(int $port, string $documentRoot, ?string $routerScript) : string
    {
        $address = '127.0.0.1:' . $port;

        $command = \escapeshellarg(\PHP_BINARY)
            . ' -S ' . $address
            . ' -t ' . \escapeshellarg($documentRoot);

        if ($routerScript !== null) {
            $command .= ' ' . \escapeshellarg($routerScript);
        }

        return $command;
    }

    protected function executeServer(string $command) : int
    {
        \passthru($command, $exitCode);
        return $exitCode;
    }

    protected function normalizePath(string $path) : string
    {
        $realpath = \realpath($path);
        if ($realpath !== false) {
            return $realpath;
        }

        return \rtrim($path, '/\\');
    }
}
