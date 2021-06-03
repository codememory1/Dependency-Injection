<?php

namespace Codememory\Container\DependencyInjection\Exceptions;

use JetBrains\PhpStorm\Pure;

/**
 * Class AutowriteReservedException
 * @package Codememory\Container\DependencyInjection\Exceptions
 *
 * @author  Codememory
 */
class AutowriteReservedException extends DependencyInjectionException
{

    /**
     * AutowriteReservedException constructor.
     *
     * @param string $propertyName
     */
    #[Pure] public function __construct(string $propertyName)
    {

        parent::__construct(sprintf(
            'It is impossible to automatically pass the dependency because the %s property has a reserved type',
            $propertyName
        ));

    }

}