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
class BooleanValidatorTest extends PHPUnit\Framework\TestCase
{
    public function testValidateParam()
    {
        $validator = new \Glicerine\validators\BooleanValidator();

        $this->assertFalse($validator->validate('Yes'));
        $this->assertFalse($validator->validate('test'));
        $this->assertFalse($validator->validate('-1'));
        $this->assertFalse($validator->validate('2'));

        $this->assertTrue($validator->validate('true'));
        $this->assertTrue($validator->validate('TRUE'));
        $this->assertTrue($validator->validate('false'));
        $this->assertTrue($validator->validate('FALSE'));
        $this->assertTrue($validator->validate('1'));
        $this->assertTrue($validator->validate('0'));

        $validator->setProperty('tfValues', ['si', 'no']);
        $this->assertTrue($validator->validate('si'));
        $this->assertTrue($validator->validate('no'));

    }

    public function testFilterParam()
    {
        $validator = new \Glicerine\validators\BooleanValidator(['filter' => true]);
        $validator->validate('true');
        $this->assertTrue($validator->getFilteredParam() === true);
        
        $validator->validate('ccc');
        $this->assertFalse($validator->getFilteredParam() === true);

        $validator->validate('false');
        $this->assertTrue($validator->getFilteredParam() === false);

        $validator->validate('0');
        $this->assertTrue($validator->getFilteredParam() === false);
    }
}
