<?php

namespace Codememory\Container\DependencyInjection;

use Codememory\Container\DependencyInjection\Interfaces\ParametersInterface;
use Generator;

/**
 * Class Parameters
 * @package Codememory\Container\DependencyInjection
 *
 * @author  Codememory
 */
class Parameters implements ParametersInterface
{

    /**
     * @var array
     */
    private array $definitionParameters;

    /**
     * @var array
     */
    private array $addedParameters = [];

    /**
     * @var array
     */
    private array $autowriteParameters = [];

    /**
     * Parameters constructor.
     *
     * @param array $definitionParameters
     */
    public function __construct(array $definitionParameters = [])
    {

        $this->definitionParameters = $definitionParameters;

    }

    /**
     * @inheritDoc
     */
    public function addParameter(mixed $value): ParametersInterface
    {

        $this->addedParameters[] = $value;

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function addParameterByName(string $name, mixed $value): ParametersInterface
    {

        $this->addedParameters[$name] = $value;

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function addParameters(array $parameters): ParametersInterface
    {

        $this->addedParameters = array_merge($this->addedParameters, $parameters);

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function withAutowrite(Autowrite $autowrite): ParametersInterface
    {

        $this->autowriteParameters = $autowrite->make()->getDependency();

        return $this;

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Returns a sorted array of injection parameters
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @return array
     */
    public function get(): array
    {

        $parameterWarehouse = [];

        foreach ($this->iterationAddedParameters() as [$currentPosition, $nameAddedParameter, $valueAddedParameter, $index, $dataDefinitionParameter]) {
            if (is_string($nameAddedParameter)) {
                if ($nameAddedParameter === $dataDefinitionParameter['parameterName']) {
                    $parameterWarehouse[$dataDefinitionParameter['position']] = $valueAddedParameter;
                }
            } else {
                $parameterWarehouse[$currentPosition] = $valueAddedParameter;
            }
        }

        return $this->iterationAutowriteParameters(
            $this->filterParameters($parameterWarehouse)
        );

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Iterating autowrite parameters and returning parameters
     * combined passed and auto-substituted
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param array $mainParameters
     *
     * @return array
     */
    private function iterationAutowriteParameters(array $mainParameters): array
    {

        foreach ($this->autowriteParameters as $position => $value) {
            $mainParameters[$position] = $value;
        }

        return $mainParameters;

    }

    /**
     * @param array $parameterWarehouse
     *
     * @return array
     */
    private function filterParameters(array $parameterWarehouse): array
    {

        $parameters = [];

        while ($parameterWarehouse) {
            $min = $this->minKey($parameterWarehouse);
            $parameters[$min] = $parameterWarehouse[$min];

            unset($parameterWarehouse[$min]);
        }

        return $parameters;

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Filtering parameters from both the minimum key to the larger
     * one and return from the filtered parameters
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param array $array
     *
     * @return int
     */
    private function minKey(array $array): int
    {

        $keys = [];

        foreach ($array as $key => $value) {
            $keys[] = $key;
        }

        return min($keys);

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Iterate the added parameters and return a generator
     * with all the parameter data
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @return Generator
     */
    private function iterationAddedParameters(): Generator
    {

        $currentPosition = 0;

        foreach ($this->addedParameters as $nameAddedParameter => $valueAddedParameter) {
            ++$currentPosition;

            foreach ($this->definitionParameters as $index => $dataDefinitionParameter) {
                yield [$currentPosition - 1, $nameAddedParameter, $valueAddedParameter, $index, $dataDefinitionParameter];
            }
        }

    }

}