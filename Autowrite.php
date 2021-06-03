<?php

namespace Codememory\Container\DependencyInjection;

use Codememory\Support\Arr;
use ReflectionClass;
use ReflectionException;

/**
 * Class Autowrite
 * @package Codememory\Container\DependencyInjection
 *
 * @author  Codememory
 */
class Autowrite
{

    /**
     * @var array
     */
    private array $parameters;

    /**
     * @var array
     */
    private array $dependency = [];

    /**
     * @var Parameters
     */
    private Parameters $transmissionParameters;

    /**
     * Autowrite constructor.
     *
     * @param array      $requiredParameters
     * @param Parameters $transmissionParameters
     */
    public function __construct(array $requiredParameters, Parameters $transmissionParameters)
    {

        $this->parameters = $requiredParameters;
        $this->transmissionParameters = $transmissionParameters;

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Get an array of dependencies
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @return array
     */
    public function getDependency(): array
    {

        return $this->dependency;

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Do processing of input parameters and automatically add
     * parameters to the array of dependencies
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @return Autowrite
     */
    public function make(): Autowrite
    {

        return $this->iterateParameter();

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Iteration of the parameter, it is initially checked, if
     * the type of parameter is 1, you can start creating and
     * adding a dependency to the list, then the parameter that
     * is added automatically is processed, it checks if the
     * parameter is added manually, then the value will not
     * be added automatically, etc.
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @return Autowrite
     */
    private function iterateParameter(): Autowrite
    {

        return $this->iterationParameters(function (array $types, array $parameterData) {
            if (count($types) === 1) {
                $type = $types[array_key_last($types)];

                if (!in_array($type, DependencyInjection::RESERVED_TYPES)) {
                    $this->dependency[$parameterData['parameterName']] = [
                        'position' => $parameterData['position'],
                        'value'    => $this->importDependency($type)
                    ];
                }
            }
        })->iterationDependency(function (mixed $name, array $data) {
            $transmissionParameters = $this->transmissionParameters->get();

            if (Arr::exists($transmissionParameters, $name)) {
                $this->dependency[$data['position']] = $transmissionParameters[$name];
            } elseif (Arr::exists($transmissionParameters, $data['position'])) {
                $this->dependency[$data['position']] = $transmissionParameters[$data['position']];
                unset($this->dependency[$name]);
            } else {
                $this->dependency[$data['position']] = $data['value'];
            }

            unset($this->dependency[$name]);
        });

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Iterating Dependencies and Calling a Handler Callback
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param callable $handle
     *
     * @return Autowrite
     */
    private function iterationDependency(callable $handle): Autowrite
    {

        foreach ($this->dependency as $name => $data) {
            call_user_func($handle, $name, $data);
        }

        return $this;

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Returns an object of the class specified in the parameter type
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param string $type
     *
     * @return mixed
     * @throws ReflectionException
     */
    private function importDependency(string $type): mixed
    {

        $reflectorDependency = new ReflectionClass($type);
        $namespace = $reflectorDependency->getName();

        return new $namespace();

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Iterate the parameters to be passed and call the callback handler
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param callable $handle
     *
     * @return Autowrite
     */
    private function iterationParameters(callable $handle): Autowrite
    {

        foreach ($this->parameters as $parameterData) {
            $types = $parameterData['types'];

            call_user_func($handle, $types, $parameterData);
        }

        return $this;

    }

}