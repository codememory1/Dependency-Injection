<?php

namespace Codememory\Container\DependencyInjection\Interfaces;

use Codememory\Container\DependencyInjection\ClassBelongs;
use ReflectionMethod;
use ReflectionProperty;

/**
 * Interface ReflectorClassInterface
 * @package Codememory\Container\DependencyInjection\Interfaces
 *
 * @author  Codememory
 */
interface ReflectorClassInterface
{

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Returns an array of injection parameters whose value
     * is the ReflectionParameter object
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param ReflectionMethod $method
     *
     * @return array
     */
    public function getReflectionParameters(ReflectionMethod $method): array;

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Returns an array of injection parameters
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param ReflectionMethod $method
     *
     * @return array
     */
    public function getArrayParameters(ReflectionMethod $method): array;

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Get the ReflectionMethod of a constructor
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @return ReflectionMethod
     */
    public function getConstruct(): ReflectionMethod;

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Get the ReflectionMethod of a specific method
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param string $name
     *
     * @return ReflectionMethod
     */
    public function getMethod(string $name): ReflectionMethod;

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Get the ReflectionMethod of a specific property
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param string $name
     *
     * @return ReflectionProperty
     */
    public function getProperty(string $name): ReflectionProperty;

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Returns an object of the ClassBelongs class with which you
     * can check the existence of a property or methods
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @return ClassBelongs
     */
    public function getBelongs(): ClassBelongs;

}