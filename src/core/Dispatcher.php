<?php

namespace Glicerine\core;

use Glicerine\exceptions\ClassNotFoundException;
use Glicerine\exceptions\GlicerineException;

/**
 * Description of Dispatcher
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class Dispatcher
{

    const DEFAULT_ACTION = 'main';
    const DEFAULT_COMMAND = 'main';

    public function run(CliParams $params)
    {
        $commandName = $params->getCommand() ?? $this->getDefaultCommand();
        $action = $params->getAction() ?? $this->getDefaultAction();
        $commandsNamespace = Cli::getConfig()->getParam('commandsNamespace');
        $commandClass = $commandsNamespace.'\\'.ucfirst($commandName).'Command';
        if(!class_exists($commandClass)){
            throw new ClassNotFoundException('Class '.$commandClass.' not found');
        }
        if (!is_subclass_of($commandClass, 'Glicerine\core\Command')) {
            throw new GlicerineException('Class must extend Glicerine\core\Command class');
        }
        $command = new $commandClass($params);
        $this->runAction($command, $action);
    }

    private function runAction($command, $action)
    {
        if($command->validateParams($action)){
            $command->$action();
        }
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
