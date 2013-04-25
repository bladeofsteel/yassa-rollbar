<?php
namespace Yassa\Rollbar;

use RollbarNotifier;
use Zend\EventManager\EventInterface;

class Module
{
    public function onBootstrap(EventInterface $event)
    {
        $config = $event->getApplication()->getServiceManager()->get('Config');

        if (isset($config['yassa_rollbar'])) {
            $rollbar = new RollbarNotifier($config['yassa_rollbar']);

            set_exception_handler(array($rollbar, "report_exception"));
            set_error_handler(array($rollbar, "report_php_error"));
            register_shutdown_function(
                function () use ($rollbar) {
                    // Catch any fatal errors that are causing the shutdown
                    $last_error = error_get_last();
                    if (!is_null($last_error)) {
                        switch ($last_error['type']) {
                            case E_ERROR:
                                $rollbar->report_php_error(
                                    $last_error['type'],
                                    $last_error['message'],
                                    $last_error['file'],
                                    $last_error['line']
                                );
                                break;
                        }
                    }
                    $rollbar->flush();
                }
            );
        }
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
