<?php

namespace Codememory\Container\DependencyInjection\Reflector;

use Codememory\Container\DependencyInjection\ClassBelongs;
use Codememory\Container\DependencyInjection\Exceptions\ConstructNotFoundException;
use Codememory\Container\DependencyInjection\Exceptions\MethodNotFoundException;
use Codememory\Container\DependencyInjection\Exceptions\PropertyNotFoundException;
use Codememory\Container\DependencyInjection\Interfaces\ReflectorClassInterface;
use JetBrains\PhpStorm\Pure;
use ReflectionException;
use ReflectionMethod;
use ReflectionProperty;

/**
 * Class ReflectorClass
 * @package Codememory\Container\DependencyInjection
 *
 * @author  Codememory
 */
final class ReflectorClass extends ReflectorAbstract implements ReflectorClassInterface
{

    /**
     * @inheritDoc
     */
    public function getReflectionParameters(ReflectionMethod $method): array
    {

        return $this->reflectorParameters($method);

    }

    /**
     * @inheritDoc
     */
    public function getArrayParameters(ReflectionMethod $method): array
    {

        return $this->arrayParameters($method);

    }

    /**
     * @inheritDoc
     * @throws ConstructNotFoundException
     */
    public function getConstruct(): ReflectionMethod
    {

        if(!$this->getBelongs()->construct()) {
            throw new ConstructNotFoundException($this->reflector->getReflection()->getName());
        }

        return $this->reflector->getReflection()->getConstructor();

    }

    /**
     * @inheritDoc
     * @throws MethodNotFoundException
     * @throws ReflectionException
     */
    public function getMethod(string $name): ReflectionMethod
    {

        if(!$this->getBelongs()->method($name)) {
            throw new MethodNotFoundException($this->reflector->getReflection()->getName(), $name);
        }

        return $this->reflector->getReflection()->getMethod($name);

    }

    /**
     * @inheritDoc
     * @throws ReflectionException
     * @throws PropertyNotFoundException
     */
    public function getProperty(string $name): ReflectionProperty
    {

        if(!$this->getBelongs()->property($name)) {
            throw new PropertyNotFoundException($this->reflector->getReflection()->getName(), $name);
        }

        return $this->reflector->getReflection()->getProperty($name);

    }

    /**
     * @inheritDoc
     */
    #[Pure] public function getBelongs(): ClassBelongs
    {

        return new ClassBelongs($this->reflector);

    }

}