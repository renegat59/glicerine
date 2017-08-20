<?php

/**
 * Description of CliParamsTest
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class CliParamsTest extends PHPUnit\Framework\TestCase
{
    public function testCwd()
    {
        $cliParams = new \Glicerine\core\CliParams(['test'], 1, '/');
        $this->assertEquals('/', $cliParams->getCwd());
    }

    public function testAction()
    {
        $cliParams = new \Glicerine\core\CliParams(['test'], 1, '/');
        $this->assertNull($cliParams->getAction());
    }


    public function testCommand()
    {
        $cliParams = new \Glicerine\core\CliParams(['test'], 1, '/');
        $this->assertNull($cliParams->getCommand());
    }

    public function testScriptName()
    {
        $cliParams = new \Glicerine\core\CliParams(['test'], 1, '/');
        $this->assertEquals('test', $cliParams->getScriptName());
    }

    public function testParams()
    {
        $cliParams = new \Glicerine\core\CliParams(['test'], 1, '/');
        $this->assertNull($cliParams->getCommand());
        $this->assertNull($cliParams->getAction());
        $this->assertNull($cliParams->getParam('param1'));

        $cliParams = new \Glicerine\core\CliParams(['test', 'cmd'], 2, '/');
        $this->assertEquals('cmd', $cliParams->getCommand());
        $this->assertNull($cliParams->getAction());
        $this->assertNull($cliParams->getParam('param1'));

        $cliParams = new \Glicerine\core\CliParams(['test', 'cmd', 'act'], 3, '/');
        $this->assertEquals('cmd', $cliParams->getCommand());
        $this->assertEquals('act', $cliParams->getAction());
        $this->assertNull($cliParams->getParam('param1'));

        $this->expectException(\Glicerine\exceptions\InvalidCommandException::class);
        $cliParams = new \Glicerine\core\CliParams(['test', '--param1', 'cmd'], 3, '/');

        $this->expectException(\Glicerine\exceptions\InvalidCommandException::class);
        $cliParams = new \Glicerine\core\CliParams(['test', '--param1', '--param2', 'cmd'], 4, '/');

        $cliParams = new \Glicerine\core\CliParams(['test', 'cmd', 'act', '--param1=1'], 3, '/');

        $this->assertEquals('cmd', $cliParams->getCommand());
        $this->assertEquals('act', $cliParams->getAction());
        $this->assertEquals('1', $cliParams->getParam('param1'));

        

    }

}
