<?php

namespace Codememory\Container\DependencyInjection;

use Codememory\Container\DependencyInjection\Exceptions\AutowriteReservedException;
use Codememory\Container\DependencyInjection\Interfaces\ReflectorInterface;
use ReflectionClass;
use ReflectionException;

/**
 * Class PropertyAutowrite
 * @package Codememory\Container\DependencyInjection
 *
 * @author  Codememory
 */
class PropertyAutowrite
{

    /**
     * @var ReflectorInterface
     */
    private ReflectorInterface $reflector;

    /**
     * @var array
     */
    private array $types;

    /**
     * @var string
     */
    private string $propertyName;

    /**
     * PropertyAutowrite constructor.
     *
     * @param ReflectorInterface $reflector
     * @param string             $propertyName
     * @param array              $types
     */
    public function __construct(ReflectorInterface $reflector, string $propertyName, array $types)
    {

        $this->reflector = $reflector;
        $this->propertyName = $propertyName;
        $this->types = $types;

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Get autowrite property value
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @return object|bool
     * @throws AutowriteReservedException
     * @throws ReflectionException
     */
    public function getValueForProperty(): object|bool
    {

        return $this->defineType();

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Check the correctness of the property type, if the property
     * has the same type and it is not reserved, then an object of
     * this type is created and this object is returned
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @return false|object
     * @throws ReflectionException
     * @throws AutowriteReservedException
     */
    private function defineType(): bool|object
    {

        if (count($this->types) > 1) {
            throw new AutowriteReservedException($this->propertyName);
        }

        if (count($this->types) === 1) {
            $type = $this->types[array_key_last($this->types)];

            if (!$this->reflector->isReservedType($type)) {
                $reflectorDependency = new ReflectionClass($type);
                $namespace = $reflectorDependency->getName();

                return new $namespace();
            }

            throw new AutowriteReservedException($this->propertyName);
        }

        return false;

    }

}