<?php

namespace Codememory\Container\DependencyInjection\Interfaces;

/**
 * Interface DependencyInjectionInterface
 * @package Codememory\Container\DependencyInjection\Interfaces
 *
 * @author  Codememory
 */
interface DependencyInjectionInterface
{

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Add a new definition, the first argument is the name
     * of the definition by which you can get the definition
     * itself, the second argument is a function or namespace,
     * and the third is a callback with the InjectionInterface
     * parameter
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param string          $id
     * @param callable|string $definition
     * @param callable|null   $handleInjection
     *
     * @return DependencyInjectionInterface
     */
    public function add(string $id, callable|string $definition, ?callable $handleInjection = null): DependencyInjectionInterface;

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Returns a boolean value by checking the existence
     * of the definition
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param string $id
     *
     * @return bool
     */
    public function exist(string $id): bool;

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Returns the processed definition by name
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param string $id
     *
     * @return mixed
     */
    public function get(string $id): mixed;

}