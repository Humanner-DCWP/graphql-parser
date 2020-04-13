<?php

declare(strict_types=1);

namespace Youshido\GraphQL\Exception\Interfaces;

/**
 * Interface for GraphQL exceptions that have "extensions" defined
 */
interface ExtendedExceptionInterface
{

    /**
     * @return array
     */
    public function getExtensions();
}
