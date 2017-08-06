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
}
