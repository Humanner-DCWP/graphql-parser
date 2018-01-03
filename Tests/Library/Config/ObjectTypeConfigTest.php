<?php

namespace Youshido\Tests\Library\Config;

use Youshido\GraphQL\Config\Object\ObjectTypeConfig;
use Youshido\GraphQL\Type\AbstractInterfaceTypeInterface;
use Youshido\GraphQL\Type\Scalar\IntType;
use Youshido\GraphQL\Type\Scalar\StringType;

/**
 * Class ObjectTypeConfigTest
 */
class ObjectTypeConfigTest extends \PHPUnit_Framework_TestCase
{
    public function testCreation()
    {
        $config = new ObjectTypeConfig([
            'name'   => 'Test',
            'fields' => [
                'id' => new StringType(),
            ],
        ]);

        $this->assertEquals($config->getName(), 'Test', 'Normal creation');
    }

    /**
     * @param array $config
     *
     * @expectedException Youshido\GraphQL\Exception\ConfigurationException
     * @dataProvider invalidConfigs
     */
    public function testInvalidConfigs(array $config)
    {
        $config = new ObjectTypeConfig($config);
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
                    'name' => 'name',
                ],
            ],
            [
                [
                    'fields' => [
                        'id' => new StringType(),
                    ],
                ],
            ],
            [
                [
                    'name'   => '',
                    'fields' => [
                        'id' => new StringType(),
                    ],
                ],
            ],
            [
                [
                    'name'   => 'name',
                    'fields' => [],
                ],
            ],
        ];
    }

    public function testProps()
    {
        $config = new ObjectTypeConfig([
            'name'   => 'test',
            'fields' => [
                'id' => new StringType(),
            ],
        ]);

        $this->assertEquals('test', $config->getName());
        $config->setName('test2');
        $this->assertEquals('test2', $config->getName());

        $this->assertTrue($config->hasFields());
        $this->assertTrue($config->hasField('id'));

        $config->removeField('id');
        $this->assertFalse($config->hasField('id'));
        $this->assertFalse($config->hasFields());

        $config->addFields([
            'id2' => new IntType(),
        ]);
        $this->assertTrue($config->hasFields());
        $this->assertTrue($config->hasField('id2'));

        $this->assertNull($config->getDescription());
        $config->setDescription('desc');
        $this->assertEquals('desc', $config->getDescription());

        $this->assertEmpty($config->getInterfaces());
        $interface = $this->getMock(AbstractInterfaceTypeInterface::class);
        $config->setInterfaces([$interface]);

        $this->assertEquals([$interface], $config->getInterfaces());
    }
}
