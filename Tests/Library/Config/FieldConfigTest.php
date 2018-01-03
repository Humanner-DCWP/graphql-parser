<?php

namespace Youshido\Tests\Library\Config;

use Youshido\GraphQL\Config\Field\FieldConfig;
use Youshido\GraphQL\Type\Scalar\IdType;
use Youshido\GraphQL\Type\Scalar\IntType;
use Youshido\GraphQL\Type\Scalar\StringType;

/**
 * Class FieldConfigTest
 */
class FieldConfigTest extends \PHPUnit_Framework_TestCase
{
    public function testInvalidParams()
    {
        $config = new FieldConfig([
            'name' => 'Field',
            'type' => new StringType(),
            'args' => [
                'id' => new IdType(),
            ],
        ]);

        $this->assertEquals('Field', $config->getName());
        $config->setName('test');
        $this->assertEquals('test', $config->getName());

        $this->assertEquals(new StringType(), $config->getType());
        $config->setType(new IdType());
        $this->assertEquals(new IdType(), $config->getType());

        $this->assertNull($config->getDescription());
        $config->setDescription('desc');
        $this->assertEquals('desc', $config->getDescription());

        $this->assertTrue($config->hasArguments());
        $this->assertTrue($config->hasArgument('id'));

        $this->assertNull($config->getDeprecationReason());
        $config->setDeprecationReason('dep');
        $this->assertEquals('dep', $config->getDeprecationReason());

        $this->assertFalse($config->isDeprecated());
        $config->setIsDeprecated(true);
        $this->assertTrue($config->isDeprecated());

        $this->assertEquals(null, $config->getCost());
        $config->setCost(123);
        $this->assertEquals(123, $config->getCost());

        $this->assertNull($config->getResolve());
        $config->setResolve(function () {
        });
        $this->assertEquals(function () {
        }, $config->getResolve());
    }

    /**
     * @param array $config
     *
     * @expectedException Youshido\GraphQL\Exception\ConfigurationException
     * @dataProvider invalidConfigs
     */
    public function testInvalidConfigs(array $config)
    {
        $config = new FieldConfig($config);
        $config->validate();
    }

    public function invalidConfigs()
    {
        $args = [
            'id' => new IdType(),
        ];

        return [
            [
                [],
            ],
            [
                [
                    'name' => '',
                ],
            ],
            [
                [
                    'name' => '',
                    'type' => new IntType(),
                    'args' => $args,
                    'cost' => 1
                ],
            ],
            [
                [
                    'name' => 'test',
                    'type' => new IntType(),
                    'args' => $args,
                    'cost' => '123'
                ],
            ],
            [
                [
                    'name' => 'test',
                    'type' => new \stdClass(),
                    'args' => $args,
                    'cost' => 12
                ],
            ],
        ];
    }
}
