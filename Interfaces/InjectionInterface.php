<?php

namespace Codememory\Container\DependencyInjection\Interfaces;

/**
 * Interface InjectionInterface
 * @package Codememory\Container\DependencyInjection\Interfaces
 *
 * @author  Codememory
 */
interface InjectionInterface
{

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Constructor Dependency Injection
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param array $parameters
     * @param bool  $autowrite
     *
     * @return InjectionInterface
     */
    public function construct(array $parameters = [], bool $autowrite = false): InjectionInterface;

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Dependency injection through a specific method
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param string $name
     * @param array  $parameters
     * @param bool   $autowrite
     *
     * @return InjectionInterface
     */
    public function method(string $name, array $parameters = [], bool $autowrite = false): InjectionInterface;

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Dependency injection via property. If you need to set autowrite
     * property values must be null, otherwise autowrite will not work
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param string $name
     * @param mixed  $value
     * @param bool   $autowrite
     *
     * @return InjectionInterface
     */
    public function property(string $name, mixed $value, bool $autowrite = false): InjectionInterface;

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Add dependencies to callback or enable automation
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param array $parameters
     * @param bool  $autowrite
     *
     * @return InjectionInterface
     */
    public function callback(array $parameters, bool $autowrite = false): InjectionInterface;

}