<?php

namespace Codememory\Container\DependencyInjection\Traits;

use Codememory\Container\DependencyInjection\Definition;
use Codememory\Container\DependencyInjection\Exceptions\AutowriteReservedException;
use Codememory\Container\DependencyInjection\PropertyAutowrite;
use ReflectionException;

/**
 * Trait IterationInjectionsTrait
 * @package Codememory\Container\DependencyInjection\Traits
 *
 * @author  Codememory
 */
trait IterationInjectionsTrait
{

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * The handler of which creates an instance of the class and passes
     * the necessary parameters to the constructor, and then the
     * finished object is written to the property for further work
     * with it or to get it
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @return Definition
     */
    private function constructorIteration(): Definition
    {

        $injection = $this->injection->getInjection('construct');
        $reflection = $this->reflector->getReflection();
        $namespace = $reflection->getName();

        if ([] !== $injection) {
            $parameters = $this->parametersProcessing(
                $this->reflector->getReflector()->getConstruct(),
                $injection['parameters'],
                $injection['autowrite']
            );

            $this->processedDefinition = $reflection->newInstanceArgs($parameters->get());
        } else {
            $this->processedDefinition = new $namespace();
        }

        return $this;

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * The method is identical to the constructorIteration method,
     * only here actions are not with construct, but with a specific method
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @return Definition
     */
    private function iterationMethods(): Definition
    {

        $injection = $this->injection->getInjection('method');

        if ([] !== $injection) {
            foreach ($injection as $methodData) {
                $methodName = $methodData['name'];

                $parameters = $this->parametersProcessing(
                    $this->reflector->getReflector()->getMethod($methodName),
                    $methodData['parameters'],
                    $methodData['autowrite']
                );

                call_user_func_array([$this->processedDefinition, $methodName], $parameters->get());
            }
        }

        return $this;

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * The same method as iterationMethods only in this method
     * actions happen with properties
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @return Definition
     * @throws AutowriteReservedException
     * @throws ReflectionException
     */
    private function propertyIteration(): Definition
    {

        $injection = $this->injection->getInjection('property');

        if ([] !== $injection) {
            foreach ($injection as $propertyData) {
                $name = $propertyData['name'];
                $value = $propertyData['value'];
                $types = $this->reflector->getParameterTypes(
                    $this->reflector->getReflector()->getProperty($name)
                );

                if ($propertyData['autowrite']) {
                    $autowrite = new PropertyAutowrite($this->reflector, $name, $types);

                    $value = null === $value ? $autowrite->getValueForProperty() : $value;
                }

                $this->processedDefinition->{$name} = $value;
            }
        }

        return $this;

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * The callback iteration is passed all the required parameters
     * and the callback is written to the property to get the result
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @return Definition
     */
    private function callbackIteration(): Definition
    {

        $injection = $this->injection->getInjection('callback');

        $parameters = $this->parametersProcessing(
            $this->reflector->getReflector()->getArrayParameters(),
            $injection['parameters'] ?? [],
            $injection['autowrite'] ?? false
        );

        $this->processedDefinition = $this->reflector->getReflection()->invokeArgs($parameters->get());

        return $this;

    }

}