<?php
/**
 * Date: 07.12.15
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\Tests\StarWars\Schema;


use Youshido\GraphQL\Config\TypeConfigInterface;
use Youshido\GraphQL\Type\ListType\ListType;
use Youshido\GraphQL\Type\NonNullType;
use Youshido\GraphQL\Type\Object\AbstractObjectType;
use Youshido\GraphQL\Type\Scalar\IdType;
use Youshido\GraphQL\Type\Scalar\StringType;
use Youshido\GraphQL\Type\TypeMap;

class HumanType extends AbstractObjectType
{

    public function resolve($value = null, $args = [], $type = null)
    {
        $humans = StarWarsData::humans();

        return isset($humans[$args['id']]) ? $humans[$args['id']] : null;
    }

    public function build($config)
    {
        $config
            ->addField('id', new NonNullType(new IdType()))
            ->addField('name', new NonNullType(new StringType()))
            ->addField('friends', [
                'type' => new ListType(new CharacterInterface()),
                'resolve' => function ($droid) {
                    return StarWarsData::getFriends($droid);
                },
            ])
            ->addField('appearsIn', new ListType(new EpisodeEnum()))
            ->addField('homePlanet', TypeMap::TYPE_STRING);

        $config
            ->addArgument('id', TypeMap::TYPE_ID);
    }

    public function getInterfaces()
    {
        return [new CharacterInterface()];
    }

}
