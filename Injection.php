<?php

namespace Codememory\Container\DependencyInjection;

use Codememory\Container\DependencyInjection\Interfaces\InjectionInterface;
use JetBrains\PhpStorm\Pure;

/**
 * Class Injection
 * @package Codememory\Container\DependencyInjection
 *
 * @author  Codememory
 */
class Injection implements InjectionInterface
{

    /**
     * @var array
     */
    private array $injectionTypes = [];

    /**
     * @inheritDoc
     */
    public function construct(array $parameters = [], bool $autowrite = false): InjectionInterface
    {

        $this->injectionTypes['construct'] = [
            'parameters' => $parameters,
            'autowrite'  => $autowrite
        ];

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function method(string $name, array $parameters = [], bool $autowrite = false): InjectionInterface
    {

        $this->injectionTypes['method'][] = [
            'name'       => $name,
            'parameters' => $parameters,
            'autowrite'  => $autowrite
        ];

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function property(string $name, mixed $value, bool $autowrite = false): InjectionInterface
    {

        $this->injectionTypes['property'][] = [
            'name'      => $name,
            'value'     => $value,
            'autowrite' => $autowrite
        ];

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function callback(array $parameters, bool $autowrite = false): InjectionInterface
    {

        $this->injectionTypes['callback'] = [
            'parameters' => $parameters,
            'autowrite'  => $autowrite
        ];

        return $this;

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Returns an array of injections, their parameters
     * and the autowrite status
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @return array
     */
    public function getInjectionTypes(): array
    {

        return $this->injectionTypes;

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Returns specific injection data
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param string $type
     *
     * @return array
     */
    #[Pure] public function getInjection(string $type): array
    {

        return $this->getInjectionTypes()[$type] ?? [];

    }

}