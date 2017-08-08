<?php

namespace Glicerine\core;

/**
 * Description of Dispatcher
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class Dispatcher
{

    const DEFAULT_ACTION = 'main';
    const DEFAULT_COMMAND = 'main';

    private $cliParams;
    private $command;
    private $action;

    public function __construct($params)
    {
        $this->cliParams = $params;
        $this->command = $this->cliParams->getCommand() ?? $this->getDefaultCommand();
        $this->action = $this->cliParams->getAction() ?? $this->getDefaultAction();
    }

    public function run()
    {
        $commandsPath = Cli::getConfig()->getParam('commandsPath');
        $commandClass = ucfirst($this->command).'Command';
        $command = new $commandClass();
    }

    private function getDefaultCommand(): string
    {
        if(Cli::getConfig()->hasParam('defaultCommand')){
            return Cli::getConfig()->getParam('defaultCommand');
        }
        return self::DEFAULT_COMMAND;
    }

    private function getDefaultAction(): string
    {
        if(Cli::getConfig()->hasParam('defaultAction')){
            return Cli::getConfig()->getParam('defaultAction');
        }
        return self::DEFAULT_ACTION;
    }
}
