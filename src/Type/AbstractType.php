<?php

namespace Youshido\GraphQL\Type;

use Youshido\GraphQL\Type\Object\AbstractObjectType;

/**
 * Class AbstractType
 */
abstract class AbstractType implements TypeInterface
{
    protected $lastValidationError;

    /**
     * @return bool
     */
    public function isCompositeType()
    {
        return false;
    }

    /**
     * @return AbstractType
     */
    public function getNamedType()
    {
        return $this;
    }

    /**
     * @return AbstractType|AbstractObjectType
     */
    public function getNullableType()
    {
        return $this;
    }

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function getValidationError($value = null)
    {
        //todo add to interface

        return $this->lastValidationError;
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isValidValue($value)
    {
        return true;
    }

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function parseValue($value)
    {
        return $value;
    }

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function parseInputValue($value)
    {
        return $this->parseValue($value);
    }

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function serialize($value)
    {
        return $value;
    }

    /**
     * @return bool
     */
    public function isInputType()
    {
        return false;
    }
}
