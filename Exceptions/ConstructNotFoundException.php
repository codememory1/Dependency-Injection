<?php

namespace Codememory\Container\DependencyInjection\Exceptions;

use JetBrains\PhpStorm\Pure;

/**
 * Class ConstructNotFoundException
 * @package Codememory\Container\DependencyInjection\Exceptions
 *
 * @author  Codememory
 */
class ConstructNotFoundException extends DependencyInjectionException
{

    /**
     * ConstructNotFoundException constructor.
     *
     * @param string $namespace
     */
    #[Pure] public function __construct(string $namespace)
    {

        parent::__construct(sprintf(
            'In class %s, construct is not specialized',
            $namespace
        ));

    }

}