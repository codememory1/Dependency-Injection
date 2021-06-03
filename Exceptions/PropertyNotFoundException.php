<?php

namespace Codememory\Container\DependencyInjection\Exceptions;

use JetBrains\PhpStorm\Pure;

/**
 * Class PropertyNotFoundException
 * @package Codememory\Container\DependencyInjection\Exceptions
 *
 * @author  Codememory
 */
class PropertyNotFoundException extends DependencyInjectionException
{

    /**
     * PropertyNotFoundException constructor.
     *
     * @param string $namespace
     * @param string $name
     */
    #[Pure] public function __construct(string $namespace, string $name)
    {

        parent::__construct(sprintf(
            'There is no %s property in the %s class',
            $name,
            $namespace
        ));

    }

}