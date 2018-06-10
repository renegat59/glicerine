<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BooleanValidatorTest
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class RequiredValidatorTest extends PHPUnit\Framework\TestCase
{
    public function testValidateParam()
    {
        $validator = new \Glicerine\validators\RequiredValidator();

        $this->assertFalse($validator->validate(''));
        $this->assertTrue($validator->validate('something'));

    }
}
