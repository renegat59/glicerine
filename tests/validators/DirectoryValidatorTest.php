<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DirectoryValidatorTest
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class DirectoryValidatorTest extends PHPUnit\Framework\TestCase
{
    public function testValidateParam()
    {
        $validator = new \Glicerine\validators\DirectoryValidator();

        $this->assertTrue($validator->validate('/'));
        $this->assertFalse($validator->validate('?/test'));

        $validator->setProperty('checkExists', true);

        $this->assertTrue($validator->validate('/'));
        $this->assertFalse($validator->validate('./notexistingpath'));

    }
}
