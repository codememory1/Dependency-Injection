<?php

namespace Codememory\Container\DependencyInjection;

use Codememory\Container\DependencyInjection\Interfaces\ReflectorInterface;

/**
 * Class ClassBelongs
 * @package Codememory\Container\DependencyInjection
 *
 * @author  Codememory
 */
class ClassBelongs
{

    /**
     * @var ReflectorInterface
     */
    private ReflectorInterface $reflector;

    /**
     * ExistenceInClass constructor.
     *
     * @param ReflectorInterface $reflector
     */
    public function __construct(ReflectorInterface $reflector)
    {

        $this->reflector = $reflector;

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Check the existence of a constructor
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @return bool
     */
    public function construct(): bool
    {

        return $this->reflector->getReflection()->hasMethod('__construct');

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Check for the existence of a specific method
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param string $name
     *
     * @return bool
     */
    public function method(string $name): bool
    {

        return $this->reflector->getReflection()->hasMethod($name);

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Check for the existence of a specific property
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param string $name
     *
     * @return bool
     */
    public function property(string $name): bool
    {

        return $this->reflector->getReflection()->hasProperty($name);

    }

}