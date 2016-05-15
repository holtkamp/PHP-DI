<?php

namespace DI\Test\IntegrationTest\Definitions;

use DI\ContainerBuilder;

/**
 * Test array definitions.
 *
 * @coversNothing
 */
class ArrayDefinitionTest extends \PHPUnit_Framework_TestCase
{
    public function test_array_with_values()
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions([
            'values' => [
                'value 1',
                'value 2',
            ],
        ]);
        $container = $builder->build();

        $array = $container->get('values');

        $this->assertEquals('value 1', $array[0]);
        $this->assertEquals('value 2', $array[1]);
    }

    public function test_array_with_links()
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions([
            'links'     => [
                \DI\get('dependency1'),
                \DI\get('dependency2'),
            ],
            'dependency1' => \DI\object('stdClass'),
            'dependency2' => \DI\object('stdClass'),
        ]);
        $container = $builder->build();

        $array = $container->get('links');

        $this->assertTrue($array[0] instanceof \stdClass);
        $this->assertTrue($array[1] instanceof \stdClass);
        $this->assertSame($container->get('dependency1'), $array[0]);
        $this->assertSame($container->get('dependency2'), $array[1]);
    }

    public function test_array_with_nested_definitions()
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions([
            'array' => [
                \DI\env('PHP_DI_DO_NOT_DEFINE_THIS', 'env'),
                \DI\object('stdClass'),
            ],
        ]);
        $container = $builder->build();

        $array = $container->get('array');

        $this->assertEquals('env', $array[0]);
        $this->assertEquals(new \stdClass, $array[1]);
    }

    public function test_add_entries()
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions([
            'values' => [
                'value 1',
                'value 2',
            ],
        ]);
        $builder->addDefinitions([
            'values' => \DI\add([
                'another value',
                \DI\get('foo'),
            ]),
            'foo'    => \DI\object('stdClass'),
        ]);
        $container = $builder->build();

        $array = $container->get('values');

        $this->assertCount(4, $array);
        $this->assertEquals('value 1', $array[0]);
        $this->assertEquals('value 2', $array[1]);
        $this->assertEquals('another value', $array[2]);
        $this->assertTrue($array[3] instanceof \stdClass);
    }

    public function test_add_entries_with_nested_definitions()
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions([
            'array' => [
                \DI\env('PHP_DI_DO_NOT_DEFINE_THIS', 'env'),
                \DI\object('stdClass'),
            ],
        ]);
        $builder->addDefinitions([
            'array' => \DI\add([
                \DI\env('PHP_DI_DO_NOT_DEFINE_THIS', 'foo'),
                \DI\object('stdClass'),
            ]),
        ]);
        $container = $builder->build();

        $array = $container->get('array');

        $this->assertEquals('env', $array[0]);
        $this->assertEquals(new \stdClass, $array[1]);
        $this->assertEquals('foo', $array[2]);
        $this->assertEquals(new \stdClass, $array[3]);
    }

    public function test_add_to_non_existing_array_works()
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions([
            'values' => \DI\add([
                'value 1',
            ]),
        ]);
        $container = $builder->build();

        $array = $container->get('values');

        $this->assertCount(1, $array);
        $this->assertEquals('value 1', $array[0]);
    }
}
