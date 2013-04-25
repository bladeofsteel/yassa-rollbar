<?php
namespace Yassa\Rollbar;

use Rollbar as RollbarClient;
use Zend\EventManager\EventInterface;

class Module
{
    public function onBootstrap(EventInterface $event)
    {
        $config = $event->getApplication()->getServiceManager()->get('Config');

        if (isset($config['yassa_rollbar'])) {
           RollbarClient::init($config['yassa_rollbar']);
        }
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
