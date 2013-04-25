<?php
namespace Yassa\Rollbar;

use Rollbar as RollbarNotifier;
use Zend\EventManager\EventInterface;

class Module
{
    public function onBootstrap(EventInterface $event)
    {
        // $config = $event->getApplication()->getServiceManager()->get('Config');
        // if (isset($config['view_manager']['editor'])) {
        //     $prettyPageHandler->setEditor($config['view_manager']['editor']);
        // }

        RollbarNotifier::init(array('access_token' => '0faa035473dc4c68a3b56a67b531cfef'));
    }

    public function getConfig()
    {
        echo __METHOD__;
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
