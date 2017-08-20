<?php

/**
 * Description of CliParams
 *
 * @author Mateusz P <bananq@gmail.com>
 */

namespace Glicerine\core;

class CliParams
{
    private $argv;
    private $argc;
    private $cwd;
    
    public function __construct($argv, $argc, $cwd)
    {
        $this->argv = $argv;
        $this->argc = $argc;
        $this->cwd = $cwd;
    }

    public function getScriptName(): string
    {
        return $this->argv[0];
    }

    public function getCommand()
    {
        if($this->argc > 1){
            $command = $this->argv[1];
            if(0 !== strpos($command, '--')) {
                return $command;
            }
        }
        return null;
    }

    public function getAction()
    {
        if($this->argc > 2){
            $action = $this->argv[2];
            if(0 !== strpos($action, '--')) {
                return $action;
            }
        }
        return null;
    }

    public function getCwd()
    {
        return $this->cwd;
    }

    public function getParam($param)
    {
        //TODO: Implement
    }

    public function seatParam($param, $value)
    {
        //TODO: Implement
    }
}
