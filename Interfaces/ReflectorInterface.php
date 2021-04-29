<?php

namespace Codememory\Container\DependencyInjection\Interfaces;

use JetBrains\PhpStorm\Pure;
use ReflectionClass;
use ReflectionFunction;
use ReflectionParameter;
use ReflectionProperty;
use ReflectionType;
use ReflectionUnionType;

/**
 * Interface ReflectorInterface
 * @package Codememory\Container\DependencyInjection\Interfaces
 *
 * @author  Codememory
 */
interface ReflectorInterface
{

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Returns a specific reflector class depending on definition
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @return ReflectorClassInterface|ReflectorFunctionInterface
     */
    public function getReflector(): ReflectorClassInterface|ReflectorFunctionInterface;

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Returns the reflection class depending on the definition
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @return ReflectionClass|ReflectionFunction
     */
    public function getReflection(): ReflectionClass|ReflectionFunction;

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Returns the added definition
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @return callable|string
     */
    public function getDefinition(): callable|string;

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Check if some type is reserved
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param string $type
     *
     * @return bool
     */
    #[Pure] public function isReservedType(string $type): bool;

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Returns an array of parameter types
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param ReflectionParameter|ReflectionProperty $parameter
     *
     * @return array
     */
    public function getParameterTypes(ReflectionParameter|ReflectionProperty $parameter): array;

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Returns the type of the parameter if there are several
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param ReflectionUnionType $unionType
     *
     * @return array
     */
    public function getUnionTypes(ReflectionUnionType $unionType): array;

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Returns a name of a specific type
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param ReflectionType $reflectionType
     *
     * @return string
     */
    #[Pure] public function getTypeName(ReflectionType $reflectionType): string;

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Returns the name of a specific parameter
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param ReflectionParameter|ReflectionProperty $parameter
     *
     * @return string
     */
    #[Pure] public function getParameterName(ReflectionParameter|ReflectionProperty $parameter): string;
}