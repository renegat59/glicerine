<?php

namespace Glicerine\core;

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
    
    public function __construct($argv, $argc)
    {
        $this->argv = $argv;
        $this->argc = $argc;
    }

    public function getScriptName(): string
    {
        return $this->argv[0];
    }

    public function getCommand(): string
    {
        if($this->argc > 1){
            return $this->argv[1];
        }
        return null;
    }
}
