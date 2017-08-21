<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Glicerine\console;

/**
 * Description of Input
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class Input
{
    public static function read(string $prompt = '', int $color = null): string
    {
        if(!empty($prompt)) {
            Output::write($prompt.' ', $color);
        }
        $finput = fopen('php://stdin', 'r');
        $input = fgets($finput);
        return str_replace("\n", "", $input);
    }
}
