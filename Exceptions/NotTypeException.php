<?php

namespace Codememory\Container\DependencyInjection\Exceptions;

use JetBrains\PhpStorm\Pure;

/**
 * Class NotTypeException
 * @package Codememory\Container\DependencyInjection\Exceptions
 *
 * @author  Codememory
 */
class NotTypeException extends DependencyInjectionException
{

    /**
     * NotTypeException constructor.
     *
     * @param string $parameterName
     */
    #[Pure] public function __construct(string $parameterName)
    {

        parent::__construct(sprintf(
            'The %s parameter is not of any type',
            $parameterName
        ));

    }

}