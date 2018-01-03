<?php

namespace Youshido\GraphQL\Type\Enum;

use Youshido\GraphQL\Config\Object\EnumTypeConfig;
use Youshido\GraphQL\Type\AbstractType;
use Youshido\GraphQL\Type\Traits\AutoNameTrait;
use Youshido\GraphQL\Type\Traits\ConfigAwareTrait;
use Youshido\GraphQL\Type\TypeKind;

/**
 * Class AbstractEnumType
 */
abstract class AbstractEnumType extends AbstractType
{
    use AutoNameTrait, ConfigAwareTrait;

    /**
     * ObjectType constructor.
     *
     * @param $config
     */
    public function __construct($config = [])
    {
        if (empty($config)) {
            $config['name']   = $this->getName();
        }

        $this->config = new EnumTypeConfig($config, $this);
        $this->build($this->config);
        $this->config->validate();
    }

    /**
     * @param EnumTypeConfig $config
     */
    abstract protected function build(EnumTypeConfig $config);

    /**
     * @return array
     */
    public function getValues()
    {
        return $this->getConfig()->getValues();
    }

    /**
     * @return String predefined type kind
     */
    public function getKind()
    {
        return TypeKind::KIND_ENUM;
    }

    /**
     * @param $value string
     *
     * @return bool
     */
    public function isValidValue($value)
    {
        if (null === $value) {
            return true;
        }

        foreach ((array) $this->getConfig()->get('values') as $item) {
            if ($value === $item['name'] || $value === $item['value']) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public function getValidationError($value = null)
    {
        $allowedValues = array_map(
            function (array $item) {
                return sprintf('%s (%s)', $item['name'], $item['value']);
            },
            $this->getConfig()->get('values')
        );

        return sprintf('Value must be one of the allowed ones: %s', implode(', ', $allowedValues));
    }

    /**
     * @param string $value
     *
     * @return null
     */
    public function serialize($value)
    {
        foreach ((array) $this->getConfig()->get('values') as $valueItem) {
            if ($value === $valueItem['value']) {
                return $valueItem['name'];
            }
        }

        return null;
    }

    /**
     * @param string $value
     *
     * @return null|string
     */
    public function parseValue($value)
    {
        foreach ((array) $this->getConfig()->get('values') as $valueItem) {
            if ($value === $valueItem['name']) {
                return $valueItem['value'];
            }
        }

        return null;
    }

    /**
     * @param string $value
     *
     * @return null|string
     */
    public function parseInputValue($value)
    {
        foreach ((array) $this->getConfig()->get('values') as $valueItem) {
            if ($value === $valueItem['value']) {
                return $valueItem['name'];
            }
        }

        return null;
    }
}
