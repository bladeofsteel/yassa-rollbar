<?php

namespace Yassa\Rollbar\Factory;

use Interop\Container\ContainerInterface;
use Yassa\Rollbar\View\Helper\Rollbar;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Factory for View\Helper\Rollbar class
 *
 * @package Yassa\Rollbar\Factory
 */
class RollbarViewHelperFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return Rollbar
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $options  = $container->get('Yassa\Rollbar\Options\ModuleOptions');
        return new Rollbar($options);

    }
}
