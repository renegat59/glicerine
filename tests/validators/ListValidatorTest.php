<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ListValidatorTest
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class ListValidatorTest extends PHPUnit\Framework\TestCase
{
    public function testValidateParam()
    {
        $validator = new \Glicerine\validators\ListValidator();

        $this->assertTrue($validator->validate('foo'));
        $this->assertTrue($validator->validate('foo,bar,baz'));
        $this->assertFalse($validator->validate('foo,bar,'));

        $validator->setProperty('delimiter', ';');
        $this->assertTrue($validator->validate('foo'));
        $this->assertTrue($validator->validate('foo;bar;baz'));
        $this->assertFalse($validator->validate('foo,bar;'));
    }

    public function testFilterParam()
    {
        $validator = new \Glicerine\validators\ListValidator(['filter' => true]);
        $validator->validate('foo,bar');
        $filteredValue = $validator->getFilteredParam();
        $this->assertTrue(is_array($filteredValue));
        $this->assertEquals('foo', $filteredValue[0]);
        $this->assertEquals('bar', $filteredValue[1]);
        $this->assertEquals(2, count($filteredValue));
    }
}
