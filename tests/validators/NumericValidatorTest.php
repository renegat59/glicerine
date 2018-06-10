<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NumericValidatorTest
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class NumericValidatorTest extends PHPUnit\Framework\TestCase
{
    public function testValidateParam()
    {
        $validator = new \Glicerine\validators\NumericValidator();

        $this->assertFalse($validator->validate('non-numeric'));
        $this->assertTrue($validator->validate('1'));

        $validator->setProperty('min', 0);
        $this->assertTrue($validator->validate('10'));
        $this->assertFalse($validator->validate('-10'));

        $validator->setProperty('max', 20);
        $this->assertTrue($validator->validate('10'));
        $this->assertFalse($validator->validate('30'));

        $validator->setProperty('range', [100, 150]);
        $this->assertTrue($validator->validate('110'));
        $this->assertFalse($validator->validate('30'));
        $this->assertFalse($validator->validate('200'));
    }

    public function testFilterParam()
    {
        $validator = new \Glicerine\validators\NumericValidator(['filter' => true, 'onlyInt' => true]);
        $validator->validate('1');
        $this->assertTrue($validator->getFilteredParam() === 1);

        $validator = new \Glicerine\validators\NumericValidator(['filter' => true, 'onlyFloat' => true]);
        $validator->validate('1.5');
        $this->assertTrue($validator->getFilteredParam() === 1.5);
        
    }
}
