<?php

/**
 * Main CLI Class
 *
 * @author Mateusz P <bananq@gmail.com>
 */

namespace Glicerine\core;

class Cli
{
    private $config;
    private $params;
    private $action;

    public function __construct($config, $argv, $argc)
    {
        if(ini_get('register_argc_argv') != "1") {
            throw new \Glicerine\exceptions\GlicerineException('register_argc_argv is not enabled in your INI file');
        }
        $this->params = new CliParams($argv, $argc);
        $this->config = new CliConfig($config);
    }

    public function start()
    {
        $action = $this->action ?? $this->getDefaultAction();
        echo $action;
        return ExitCode::SUCCESS;
    }

    private function getDefaultAction()
    {
        if($this->config->hasParam('defaultAction')){
            return $this->config->getParam('defaultAction');
        }
        return 'main';
    }
}
