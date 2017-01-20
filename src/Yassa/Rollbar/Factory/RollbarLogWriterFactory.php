<?php

namespace Yassa\Rollbar\Factory;

use Interop\Container\ContainerInterface;
use Yassa\Rollbar\Log\Writer\Rollbar;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Factory for Log\Writer\Rollbar class
 *
 * @package Yassa\Rollbar\Factory
 */
class RollbarLogWriterFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return Rollbar
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $notifier  = $container->get('RollbarNotifier');
        return new Rollbar($notifier);
    }
}
