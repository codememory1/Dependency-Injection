<?php

namespace Codememory\Container\DependencyInjection;

use Codememory\Container\DependencyInjection\Exceptions\NoValidNamespaceException;
use Codememory\Container\DependencyInjection\Interfaces\DependencyInjectionInterface;
use Codememory\Support\Arr;

/**
 * Class DependencyInjection
 * @package Codememory\Container\DependencyInjection
 *
 * @author  Codememory
 */
class DependencyInjection implements DependencyInjectionInterface
{

    public const RESERVED_TYPES = [
        'int', 'float', 'string', 'bool',
        'resource', 'object', 'array', 'null',
        'callable', 'iterable', 'mixed'
    ];

    /**
     * @var array
     */
    private array $definitions = [];

    /**
     * @param string          $id
     * @param callable|string $definition
     * @param callable|null   $handleInjection
     *
     * @return $this
     * @throws NoValidNamespaceException
     */
    public function setDefinition(string $id, callable|string $definition, ?callable $handleInjection = null): DependencyInjection
    {

        $injection = new Injection();

        if (is_string($definition) && !$this->validationNamespace($definition)) {
            throw new NoValidNamespaceException($definition);
        }

        if (null !== $handleInjection) {
            call_user_func_array($handleInjection, [&$injection]);
        }

        $this->definitions[$id] = new Definition($definition, $injection);

        return $this;

    }

    /**
     * @inheritDoc
     * @throws NoValidNamespaceException
     */
    public function add(string $id, callable|string $definition, ?callable $handleInjection = null): DependencyInjectionInterface
    {

        return $this->setDefinition($id, $definition, $handleInjection);

    }

    /**
     * @inheritDoc
     */
    public function exist(string $id): bool
    {

        return Arr::exists($this->definitions, $id);

    }

    /**
     * @inheritDoc
     */
    public function get(string $id): mixed
    {

        if ($this->exist($id)) {
            return $this->definitions[$id]->getProcessedDefinition();
        }

        return null;

    }

    /**
     * @param string $namespace
     *
     * @return bool
     */
    private function validationNamespace(string $namespace): bool
    {

        return class_exists($namespace);

    }

}