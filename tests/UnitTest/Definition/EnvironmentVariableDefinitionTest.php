<?php

namespace DI\Test\UnitTest\Definition;

use DI\Definition\CacheableDefinition;
use DI\Definition\EnvironmentVariableDefinition;

/**
 * @covers \DI\Definition\EnvironmentVariableDefinition
 */
class EnvironmentVariableDefinitionTest extends \PHPUnit_Framework_TestCase
{
    public function test_getters()
    {
        $definition = new EnvironmentVariableDefinition('foo', 'bar', false, 'default');

        $this->assertEquals('foo', $definition->getName());
        $this->assertEquals('bar', $definition->getVariableName());
        $this->assertFalse($definition->isOptional());
        $this->assertEquals('default', $definition->getDefaultValue());
    }

    /**
     * @test
     */
    public function should_be_cacheable()
    {
        $this->assertInstanceOf(CacheableDefinition::class, new EnvironmentVariableDefinition('foo', 'bar'));
    }
}
