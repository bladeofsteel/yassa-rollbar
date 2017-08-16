<?php

namespace Yassa\Rollbar\Factory;

use Interop\Container\ContainerInterface;
use Yassa\Rollbar\RollbarNotifier;
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
        $opt = $options->toArray();
        unset($opt['base_api_url']); //  causes 404 todo Check future rollbar versions

        $rb = new RollbarNotifier();
        $rb::init($opt);
        return $rb;
    }
}
