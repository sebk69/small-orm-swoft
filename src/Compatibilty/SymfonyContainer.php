<?php

/**
 * This file is a part of sebk/small-orm-swoft
 * Copyright 2021 - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallOrmSwoft\Compatibility;

use Swoft\Bean\Container;

class SymfonyContainer
{

    /**
     * @var SymfonyContainer
     */
    public static $symfonyContainerInstance;

    /**
     * @var Container
     */
    protected $container;

    /**
     * Can't create object : use getInstance()
     */
    private function __construct() {}

    public function getParameter($key)
    {
        return config($key);
    }

    /**
     * Get instance of symfony container
     * @return SymfonyContainer
     */
    public static function getInstance(): SymfonyContainer
    {
        if (self::$symfonyContainerInstance === null) {
            $symfonyContainer = new self();
            $symfonyContainer->container = Container::getInstance();
            self::$symfonyContainerInstance = $symfonyContainer;
        }

        return self::$symfonyContainerInstance;
    }

    /**
     * Redirect calls to container
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call(string $name, array $arguments)
    {
        if ($this->container->$name(...$arguments) instanceof ServiceDecorator) {
            return $this->container->$name(...$arguments)->getCoreInstance();
        }

        return $this->container->$name(...$arguments);
    }
}