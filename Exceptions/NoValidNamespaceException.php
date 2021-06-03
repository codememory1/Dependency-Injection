<?php

namespace Codememory\Container\DependencyInjection\Exceptions;

use JetBrains\PhpStorm\Pure;

/**
 * Class NoValidNamespaceException
 * @package Codememory\Container\DependencyInjection\Exceptions
 *
 * @author  Codememory
 */
class NoValidNamespaceException extends DependencyInjectionException
{

    /**
     * NoValidNamespaceException constructor.
     *
     * @param string $namespace
     */
    #[Pure] public function __construct(string $namespace)
    {

        parent::__construct(sprintf(
            'Incorrect namespace entered, dependency injection cannot work with this namespace(%s)',
            $namespace
        ));

    }

}