<?php

/**
 * Description of CliParams
 *
 * @author Mateusz P <bananq@gmail.com>
 */

namespace Glicerine\core;

class CliParams
{
    private $cwd;
    private $command = null;
    private $action = null;
    private $scriptName;
    private $params = [];
    
    public function __construct($argv, $argc, $cwd)
    {
        $this->cwd = $cwd;
        $this->prepareParams($argv, $argc);
    }

    public function getScriptName(): string
    {
        return $this->scriptName;
    }

    public function getCommand()
    {
        return $this->command;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getCwd()
    {
        return $this->cwd;
    }

    public function getParam(string $param)
    {
        return $this->params[$param] ?? null;
    }

    public function setParam($param, $value)
    {
        $this->params[$param] = $value;
    }

    private function addParam(string $cliParam)
    {
        if(strpos($cliParam, '=') === false) {
            $cliParam .= '=true';
        }
        list($paramName, $paramValue) = explode('=', $cliParam);
        $this->params[substr($paramName, 2)] = $paramValue;
    }

    protected function hasParams(): bool
    {
        return !empty($this->params);
    }

    private function prepareParams(array $argv, int $argc)
    {
        $this->scriptName = $argv[0];

        $argvCount = count($argv);

        if($argc !== $argvCount) {
            throw new \Glicerine\exceptions\InvalidCommandException('argc not matching length of argv');
        }

        for($index = 1; $index < $argvCount; $index++) {
            
            if(0 === strpos($argv[$index], '--')) {
                $this->addParam($argv[$index]);
            } else {
                if($index === 1) {
                    $this->command = $argv[$index];
                } elseif($index === 2 && !$this->hasParams()) {
                    $this->action = $argv[$index];
                } else {
                    throw new \Glicerine\exceptions\InvalidCommandException('Command Malformed');
                }
                
            }
        }
    }
}
