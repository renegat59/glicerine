<?php

/**
 * Main CLI Class
 *
 * @author Mateusz P <bananq@gmail.com>
 */

namespace Glicerine\core;

class Cli
{
    private $cliParams;

    private static $config;

    public function __construct($cwd, $config, $argv, $argc)
    {
        if(ini_get('register_argc_argv') != "1") {
            throw new \Glicerine\exceptions\GlicerineException('register_argc_argv is not enabled in your INI file');
        }
        Cli::setConfig(new CliConfig($config));
        $this->cliParams = new CliParams($argv, $argc, $cwd);
    }

    public function start(): int
    {
        $dispatcher = new Dispatcher();
        $dispatcher->run($this->cliParams);
        return ExitCode::SUCCESS;
    }

    private static function setConfig($config)
    {
        self::$config = $config;
    }

    public static function getConfig(): CliConfig
    {
        return self::$config;
    }
}
