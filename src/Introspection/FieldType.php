<?php

namespace Youshido\GraphQL\Introspection;

use Youshido\GraphQL\Field\FieldInterface;
use Youshido\GraphQL\Type\ListType\ListType;
use Youshido\GraphQL\Type\NonNullType;
use Youshido\GraphQL\Type\Object\AbstractObjectType;
use Youshido\GraphQL\Type\Scalar\BooleanType;
use Youshido\GraphQL\Type\Scalar\StringType;

/**
 * Class FieldType
 */
class FieldType extends AbstractObjectType
{
    /**
     * @param FieldInterface $value
     *
     * @return \Youshido\GraphQL\Type\AbstractType
     */
    public function resolveType(FieldInterface $value)
    {
        return $value->getType();
    }

    /**
     * @param FieldInterface $value
     *
     * @return array|\Youshido\GraphQL\Type\AbstractType[]
     */
    public function resolveArgs(FieldInterface $value)
    {
        if ($value->hasArguments()) {
            return $value->getArguments();
        }

        return [];
    }

    /**
     * @param \Youshido\GraphQL\Config\Object\ObjectTypeConfig $config
     */
    public function build($config)
    {
        $config
            ->addField('name', new NonNullType(new StringType()))
            ->addField('description', new StringType())
            ->addField('isDeprecated', new NonNullType(new BooleanType()))
            ->addField('deprecationReason', new StringType())
            ->addField('type', [
                'type'    => new NonNullType(new QueryType()),
                'resolve' => [$this, 'resolveType'],
            ])
            ->addField('args', [
                'type'    => new NonNullType(new ListType(new NonNullType(new InputValueType()))),
                'resolve' => [$this, 'resolveArgs'],
            ]);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isValidValue($value)
    {
        return $value instanceof FieldInterface;
    }

    /**
     * @return String type name
     */
    public function getName()
    {
        return '__Field';
    }
}
