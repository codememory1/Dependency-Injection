<?php

namespace Codememory\Container\DependencyInjection\Interfaces;

use Codememory\Container\DependencyInjection\Autowrite;

/**
 * Interface ParametersInterface
 * @package Codememory\Container\DependencyInjection\Interfaces
 *
 * @author  Codememory
 */
interface ParametersInterface
{

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Add parameter to injection
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param mixed $value
     *
     * @return ParametersInterface
     */
    public function addParameter(mixed $value): ParametersInterface;

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Add named parameter to injection
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param string $name
     * @param mixed  $value
     *
     * @return ParametersInterface
     */
    public function addParameterByName(string $name, mixed $value): ParametersInterface;

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Add an array of parameters to injection
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param array $parameters
     *
     * @return ParametersInterface
     */
    public function addParameters(array $parameters): ParametersInterface;

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Allow parameter processing using autowrite
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param Autowrite $autowrite
     *
     * @return ParametersInterface
     */
    public function withAutowrite(Autowrite $autowrite): ParametersInterface;

}