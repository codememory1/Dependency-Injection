<?php

namespace Codememory\Container\DependencyInjection\Reflector;

use Codememory\Container\DependencyInjection\Interfaces\ReflectorFunctionInterface;

/**
 * Class ReflectorFunction
 * @package Codememory\Container\DependencyInjection
 *
 * @author  Codememory
 */
final class ReflectorFunction extends ReflectorAbstract implements ReflectorFunctionInterface
{

    /**
     * @inheritDoc
     */
    public function getReflectionParameters(): array
    {

        return $this->reflectorParameters();

    }

    /**
     * @inheritDoc
     */
    public function getArrayParameters(): array
    {

        return $this->arrayParameters();

    }
}