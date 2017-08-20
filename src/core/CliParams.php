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
//        if($this->argc > 1){
//            $command = $this->argv[1];
//            if(0 !== strpos($command, '--')) {
//                return $command;
//            }
//        }
//        return null;
    }

    public function getAction()
    {
        return $this->action;
//        if($this->argc > 2){
//            $action = $this->argv[2];
//            if(0 !== strpos($action, '--')) {
//                return $action;
//            }
//        }
//        return null;
    }

    public function getCwd()
    {
        return $this->cwd;
    }

    public function getParam(string $param)
    {
        return $this->params[$param] ?? null;
    }

    public function seatParam($param, $value)
    {
        $this->params[$param] = $value;
    }

    private function prepareParams($argv, $argc)
    {
        $this->scriptName = $argv[0];
        for($index = 1; $index < $argc; $index++) {
//            if($index == 1){
//               $command = $argv[1];
//               if(0 !== strpos($command, '--')) {
//
//               }
//            }
//            if(0 === strpos($arg, '--')) {
//
//            }
        }
    }
}
