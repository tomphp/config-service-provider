<?php

namespace tests\unit\TomPHP\ConfigServiceProvider;

use PHPUnit_Framework_TestCase;
use TomPHP\ConfigServiceProvider\InflectorDefinition;

final class InflectorDefinitionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var InflectorDefinition
     */
    private $subject;

    protected function setUp()
    {
        $this->subject = new InflectorDefinition(
            'interface_name',
            ['method1' => ['arg1', 'arg2']]
        );
    }

    public function testGetInterfaceReturnsTheInterfaceName()
    {
        $this->assertEquals('interface_name', $this->subject->getInterface());
    }

    public function testGetMethodsReturnsTheMethods()
    {
        $this->assertEquals(
            ['method1' => ['arg1', 'arg2']],
            $this->subject->getMethods()
        );
    }
}