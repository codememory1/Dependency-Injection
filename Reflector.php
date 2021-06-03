<?php

namespace Codememory\Container\DependencyInjection;

use Closure;
use Codememory\Container\DependencyInjection\Exceptions\NotTypeException;
use Codememory\Container\DependencyInjection\Interfaces\ReflectorClassInterface;
use Codememory\Container\DependencyInjection\Interfaces\ReflectorFunctionInterface;
use Codememory\Container\DependencyInjection\Interfaces\ReflectorInterface;
use Codememory\Container\DependencyInjection\Reflector\ReflectorClass;
use Codememory\Container\DependencyInjection\Reflector\ReflectorFunction;
use Codememory\Support\Str;
use JetBrains\PhpStorm\Pure;
use ReflectionClass;
use ReflectionException;
use ReflectionFunction;
use ReflectionParameter;
use ReflectionProperty;
use ReflectionType;
use ReflectionUnionType;

/**
 * Class Reflector
 * @package Codememory\Container\DependencyInjection
 *
 * @author  Codememory
 */
final class Reflector implements ReflectorInterface
{

    /**
     * @var Closure|string
     */
    private Closure|string $definition;

    /**
     * Reflector constructor.
     *
     * @param callable|string $definition
     */
    public function __construct(callable|string $definition)
    {

        $this->definition = $definition;

    }

    /**
     * @inheritdoc
     */
    #[Pure] public function getReflector(): ReflectorClassInterface|ReflectorFunctionInterface
    {

        if (is_string($this->getDefinition())) {
            return new ReflectorClass($this->cloneReflector());
        }

        return new ReflectorFunction($this->cloneReflector());

    }

    /**
     * @inheritdoc
     * @throws ReflectionException
     */
    public function getReflection(): ReflectionClass|ReflectionFunction
    {

        if (is_string($this->getDefinition())) {
            return new ReflectionClass($this->getDefinition());
        }

        return new ReflectionFunction($this->getDefinition());

    }

    /**
     * @inheritdoc
     */
    public function getDefinition(): callable|string
    {

        return $this->definition;

    }

    /**
     * @inheritdoc
     */
    #[Pure] public function isReservedType(string $type): bool
    {

        return in_array(Str::toLowercase($type), DependencyInjection::RESERVED_TYPES);

    }

    /**
     * @inheritdoc
     * @throws NotTypeException
     */
    public function getParameterTypes(ReflectionParameter|ReflectionProperty $parameter): array
    {

        $reflectionType = $parameter->getType();
        $types = [];

        if (null === $reflectionType) {
            throw new NotTypeException($parameter->getName());
        }

        if ($reflectionType instanceof ReflectionUnionType) {
            $types = array_merge($types, $this->getUnionTypes($reflectionType));
        } else {
            $types[] = $this->getTypeName($reflectionType);
        }

        return $types;

    }

    /**
     * @inheritdoc
     */
    #[Pure] public function getUnionTypes(ReflectionUnionType $unionType): array
    {

        $types = [];

        foreach ($unionType->getTypes() as $type) {
            $types[] = $this->getTypeName($type);
        }

        return $types;

    }

    /**
     * @inheritdoc
     */
    #[Pure] public function getTypeName(ReflectionType $reflectionType): string
    {

        return $reflectionType->getName();

    }

    /**
     * @inheritdoc
     */
    #[Pure] public function getParameterName(ReflectionParameter|ReflectionProperty $parameter): string
    {

        return $parameter->getName();

    }

    /**
     * @return Reflector
     */
    public function cloneReflector(): Reflector
    {

        return clone $this;

    }

}