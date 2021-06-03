<?php

namespace Codememory\Container\DependencyInjection\Reflector;

use Codememory\Container\DependencyInjection\Interfaces\ReflectorInterface;
use ReflectionMethod;

/**
 * Class ReflectorAbstract
 * @package Codememory\Container\DependencyInjection
 *
 * @author  Codememory
 */
abstract class ReflectorAbstract
{

    /**
     * @var ReflectorInterface
     */
    protected ReflectorInterface $reflector;

    /**
     * ReflectorAbstract constructor.
     *
     * @param ReflectorInterface $reflector
     */
    public function __construct(ReflectorInterface $reflector)
    {

        $this->reflector = $reflector;

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Returns an array of reflector or injection parameters
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param ReflectionMethod|null $method
     *
     * @return array
     */
    protected function reflectorParameters(?ReflectionMethod $method = null): array
    {

        if (null === $method) {
            return $this->reflector->getReflection()->getParameters();
        }

        return $method->getParameters();

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Returns an array of information about all parameters of
     * the reflector or injection
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param ReflectionMethod|null $method
     *
     * @return array
     */
    protected function arrayParameters(?ReflectionMethod $method = null): array
    {

        $reflectionParameters = $this->reflectorParameters($method);
        $parameters = [];

        foreach ($reflectionParameters as $parameter) {
            $parameters[] = [
                'types'         => $this->reflector->getParameterTypes($parameter),
                'parameterName' => $this->reflector->getParameterName($parameter),
                'position'      => $parameter->getPosition()
            ];
        }

        return $parameters;

    }

}