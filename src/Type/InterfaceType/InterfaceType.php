<?php

declare(strict_types=1);
/**
 * Date: 12.05.16
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\GraphQL\Type\InterfaceType;


use Youshido\GraphQL\Config\Object\InterfaceTypeConfig;

final class InterfaceType extends AbstractInterfaceType
{

    public function __construct($config = [])
    {
        $this->config = new InterfaceTypeConfig($config, $this, true);
    }

    /**
     * @inheritdoc
     * 
     * @codeCoverageIgnore
     */
    public function build($config)
    {
    }

    public function resolveType($object)
    {
        return $this->getConfig()->resolveType($object);
    }

}
