<?php

namespace Youshido\Tests\Library\Config;

use Youshido\GraphQL\Config\Object\InterfaceTypeConfig;
use Youshido\GraphQL\Type\Scalar\IdType;

/**
 * Class InterfaceTypeConfigTest
 */
class InterfaceTypeConfigTest extends \PHPUnit_Framework_TestCase
{
    public function testCreation()
    {
        $config = new InterfaceTypeConfig([
            'name'        => 'Test',
            'fields'      => [
                'id' => new IdType(),
            ],
            'resolveType' => function () {
            },
        ]);
        $this->assertEquals($config->getName(), 'Test');

        $config->setName('test2');
        $this->assertEquals($config->getName(), 'test2');

        $this->assertNull($config->getDescription());
        $config->setDescription('desc');
        $this->assertEquals('desc', $config->getDescription());

        $this->assertEquals(function () {
        }, $config->getResolveType());
        $config->setResolveType('null');
        $this->assertEquals('null', $config->getResolveType());
    }

    /**
     * @param array $config
     *
     * @expectedException Youshido\GraphQL\Exception\ConfigurationException
     * @dataProvider invalidConfigs
     */
    public function testInvalidConfigs(array $config)
    {
        $config = new InterfaceTypeConfig($config);
        $config->validate();
    }

    public function invalidConfigs()
    {
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
                    'name'        => '',
                    'fields'      => [
                        'id' => new IdType(),
                    ],
                    'resolveType' => function () {

                    },
                ],
            ],
            [
                [
                    'name'        => null,
                    'fields'      => [
                        'id' => new IdType(),
                    ],
                    'resolveType' => function () {

                    },
                ],
            ],
            [
                [
                    'fields'      => [
                        'id' => new IdType(),
                    ],
                    'resolveType' => function () {

                    },
                ],
            ],
            [
                [
                    'name'   => 'Interface',
                    'fields' => [
                        'id' => new IdType(),
                    ],
                ],
            ],
            [
                [
                    'name'        => 'Interface',
                    'fields'      => [
                        'id' => new IdType(),
                    ],
                    'resolveType' => null,
                ],
            ],
            [
                [
                    'name'        => 'Interface',
                    'fields'      => [
                        'id' => new IdType(),
                    ],
                    'resolveType' => 'resolveFunction',
                ],
            ],
            [
                [
                    'name'        => 'Interface',
                    'fields'      => [
                    ],
                    'resolveType' => function () {

                    },
                ],
            ],
        ];
    }
}
