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
            return $this->argv[1];
        }
        return null;
    }

    public function getAction()
    {
        if($this->argc > 2){
            return $this->argv[2];
        }
        return null;
    }

    public function getCwd()
    {
        return $this->cwd;
    }
}
