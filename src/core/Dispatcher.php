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

    /**
     * @var CliParams
     */
    private $cliParams;
    private $command;
    private $action;

    public function __construct(CliParams $params)
    {
        $this->cliParams = $params;
        $this->command = $this->cliParams->getCommand() ?? $this->getDefaultCommand();
        $this->action = $this->cliParams->getAction() ?? $this->getDefaultAction();
    }

    public function run()
    {
        $commandPath = Cli::getConfig()->getParam('commandsPath', 'src/commands');
        $commandClass = ucfirst($this->command).'Command';
        require $this->cliParams->getCwd()
            .DIRECTORY_SEPARATOR
            .$commandPath
            .DIRECTORY_SEPARATOR
            .$commandClass.'.php';
//        if ($this->controllerNamespace === null) {
//            $class = get_class($this);
//            if (($pos = strrpos($class, '\\')) !== false) {
//                $this->controllerNamespace = substr($class, 0, $pos) . '\\controllers';
//            }
//        }
//        if (is_subclass_of($className, 'yii\base\Controller')) {
//            $controller = Yii::createObject($className, [$id, $this]);
//            return get_class($controller) === $className ? $controller : null;
//        } elseif (YII_DEBUG) {
//            throw new InvalidConfigException('Controller class must extend from \\yii\\base\\Controller.');
//        }
        $command = new $commandClass();
        var_dump($command);
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
