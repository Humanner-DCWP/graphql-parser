<?php

declare(strict_types=1);
/**
 * Date: 01.12.15
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\GraphQL\Parser\Ast\Interfaces;


interface ValueInterface
{

    public function getValue();

    public function setValue($value);
}