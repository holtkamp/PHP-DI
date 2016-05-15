<?php

namespace DI\Test\UnitTest\Definition;

use DI\Definition\ArrayDefinition;
use DI\Definition\CacheableDefinition;

/**
 * @covers \DI\Definition\ArrayDefinition
 */
class ArrayDefinitionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function should_contain_values()
    {
        $definition = new ArrayDefinition('foo', ['bar']);

        $this->assertEquals('foo', $definition->getName());
        $this->assertEquals(['bar'], $definition->getValues());
    }

    /**
     * @test
     */
    public function should_be_cacheable()
    {
        $this->assertNotInstanceOf(CacheableDefinition::class, new ArrayDefinition('foo', []));
    }
}
