<?php

namespace Yassa\Rollbar\Factory;

use Interop\Container\ContainerInterface;
use RollbarNotifier;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Factory for RolbarNotifier class
 *
 * @package Yassa\Rollbar\Factory
 */
class RollbarNotifierFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return RollbarNotifier
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $options  = $container->get('Yassa\Rollbar\Options\ModuleOptions');

        return new RollbarNotifier($options->toArray());
    }
}
