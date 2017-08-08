<?php

namespace Glicerine\core;

/**
 * Description of Dispatcher
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class Dispatcher
{
    private $params;
    private $command;
    private $action;

    public function __construct($params)
    {
        $this->params = $params;
        $this->command = $this->cliParams->getCommand() ?? $this->getDefaultCommand();
        $this->action = $this->cliParams->getAction() ?? $this->getDefaultAction();
    }

    public function run()
    {
        
    }

    private function getDefaultCommand(): string
    {
        if($this->config->hasParam('defaultCommand')){
            return $this->config->getParam('defaultCommand');
        }
        return self::DEFAULT_COMMAND;
    }

    private function getDefaultAction(): string
    {
        if($this->config->hasParam('defaultAction')){
            return $this->config->getParam('defaultAction');
        }
        return self::DEFAULT_ACTION;
    }
}
