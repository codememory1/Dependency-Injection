<?php

namespace Codememory\Container\DependencyInjection;

use Closure;
use Codememory\Container\DependencyInjection\Interfaces\ReflectorFunctionInterface;
use Codememory\Container\DependencyInjection\Interfaces\ReflectorInterface;
use Codememory\Container\DependencyInjection\Traits\IterationInjectionsTrait;
use ReflectionException;
use ReflectionMethod;

/**
 * Class Definition
 * @package Codememory\Container\DependencyInjection
 *
 * @author  Codememory
 */
class Definition
{

    use IterationInjectionsTrait;

    /**
     * @var Injection
     */
    private Injection $injection;

    /**
     * @var Closure|string
     */
    private Closure|string $definition;

    /**
     * @var object|null
     */
    private ?object $processedDefinition = null;

    /**
     * @var ReflectorInterface
     */
    private ReflectorInterface $reflector;

    /**
     * Definition constructor.
     *
     * @param callable|string $definition
     * @param Injection       $injection
     */
    public function __construct(callable|string $definition, Injection $injection)
    {

        $this->definition = $definition;
        $this->injection = $injection;
        $this->reflector = new Reflector($this->definition);

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Get processed definition
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @return object|null
     * @throws Exceptions\AutowriteReservedException
     * @throws ReflectionException
     */
    public function getProcessedDefinition(): ?object
    {

        if ($this->reflector->getReflector() instanceof ReflectorFunctionInterface) {
            $this->callbackIteration();
        } else {
            $this->constructorIteration();
            $this->iterationMethods();
            $this->propertyIteration();
        }

        return $this->processedDefinition;

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Get an array of parameters by reflector
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param callable $injectionParameters
     *
     * @return array
     */
    private function getArrayParameters(callable $injectionParameters): array
    {

        $reflector = $this->reflector->getReflector();

        return $reflector->getArrayParameters(
            call_user_func_array($injectionParameters, [$reflector])
        );

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * This method returns the parameters both passed and autowrite,
     * the first argument is a Reflection injection or an array of
     * parameters for this injection, the second argument is an
     * array of parameters that need to be passed, and the third
     * parameter is the use of autowrite
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param ReflectionMethod|array $injectionOrParameters
     * @param array                  $parametersForTransmission
     * @param bool                   $autowrite
     *
     * @return Parameters
     */
    private function parametersProcessing(ReflectionMethod|array $injectionOrParameters, array $parametersForTransmission, bool $autowrite): Parameters
    {

        if (is_array($injectionOrParameters)) {
            $arrayParameters = $injectionOrParameters;
        } else {
            $arrayParameters = $this->getArrayParameters(fn () => $injectionOrParameters);
        }

        $parameters = new Parameters($arrayParameters);
        $parameters->addParameters($parametersForTransmission);

        if ($autowrite) {
            $parameters->withAutowrite(new Autowrite($arrayParameters, $parameters));
        }

        return $parameters;

    }


}