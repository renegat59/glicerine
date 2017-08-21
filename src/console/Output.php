<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Glicerine\console;

/**
 * Description of Output
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class Output
{

    public static function write(string $text, int $color = null)
    {
        if ($color == null) {
            echo $text;
            return;
        }
        echo "\033[".$color."m".$text."\033[37m";
    }

    public static function writeLine(string $text, int $color = null)
    {
        self::write($text.PHP_EOL, $color);
    }

    public static function newLine($count = 1)
    {
        $lineCount = $count < 0 ? 0 : $count;
        for($ii = 0; $ii < $lineCount; $ii++) {
            self::write(PHP_EOL);
        }
    }
}
