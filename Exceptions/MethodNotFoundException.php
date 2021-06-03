<?php

namespace Codememory\Container\DependencyInjection\Exceptions;

use JetBrains\PhpStorm\Pure;

/**
 * Class MethodNotFoundException
 * @package Codememory\Container\DependencyInjection\Exceptions
 *
 * @author  Codememory
 */
class MethodNotFoundException extends DependencyInjectionException
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
            'There is no %s method in the %s class',
            $name,
            $namespace
        ));

    }

}