<?php

/**
 * Main CLI Class
 *
 * @author Mateusz P <bananq@gmail.com>
 */

namespace Glicerine\core;

use Glicerine\console\Color;
use Glicerine\console\Output;
use Glicerine\exceptions\ClassNotFoundException;
use Glicerine\exceptions\GlicerineException;
use Glicerine\exceptions\InvalidCommandException;

class Cli
{
    private $cliParams;

    private static $config;

    public function __construct($cwd, $config, $argv, $argc)
    {
        if(ini_get('register_argc_argv') != "1") {
            throw new GlicerineException('register_argc_argv is not enabled in your INI file');
        }
        Cli::setConfig(new CliConfig($config));
        
        try {
            $this->cliParams = new CliParams($argv, $argc, $cwd);
        } catch (InvalidCommandException $icex) {
            Output::writeLine('Command incorrect.', Color::RED);
            Output::writeLine('Correct syntax:');
            Output::writeLine($argv[0].' <command> <action> --param1=value1 --param2=value2');
            self::exitCli(ExitCode::CLI_ERROR);
        }
    }

    public function start(): int
    {
        $dispatcher = new Dispatcher();
        try {
            $exitCode = $dispatcher->run($this->cliParams);
            self::exitCli($exitCode);
        } catch(ClassNotFoundException $cnfex) {
            Output::writeLine('Command not found', Color::RED);
            Output::writeLine('Exception: '.$cnfex->getMessage());
            self::exitCli(ExitCode::CONFIG_ERROR);
        }
    }

    private static function setConfig($config)
    {
        self::$config = $config;
    }

    public static function getConfig(): CliConfig
    {
        return self::$config;
    }

    public static function exitCli($status)
    {
        exit($status);
    }
}
