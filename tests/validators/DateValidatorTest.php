<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DateValidatorTest
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class DateValidatorTest extends PHPUnit\Framework\TestCase
{
    public function testValidateParam()
    {
        $validator = new \Glicerine\validators\DateValidator();

        $this->assertTrue($validator->validate('2018-08-08'));
        $this->assertFalse($validator->validate('2018'));

        $validator->setProperty('format', 'Y');
        $this->assertTrue($validator->validate('2018'));
    }

    public function testFilterParam()
    {
        $validator = new \Glicerine\validators\DateValidator(['filter' => true]);
        $validator->validate('2018-08-08');
        $this->assertEquals(
          (new DateTime('2018-08-08'))->format('Y-m-d'),
          $validator->getFilteredParam()->format('Y-m-d'));
    }
}
