<?php
namespace Yassa\Rollbar;

use RollbarNotifier;
use Zend\EventManager\EventInterface;

class Module
{
    public function onBootstrap(EventInterface $event)
    {
        /** @var \Zend\Mvc\ApplicationInterface $application */
        $application = $event->getApplication();

        $config = $application->getServiceManager()->get('Config');

        if (isset($config['yassa_rollbar'])) {
            $rollbarConfig = $config['yassa_rollbar'];

            $rollbar = new RollbarNotifier($rollbarConfig);

            if (isset($rollbarConfig['exceptionhandler']) && true === $rollbarConfig['exceptionhandler']) {
                set_exception_handler(array($rollbar, "report_exception"));

                $eventManager = $application->getEventManager();
                $eventManager->attach('dispatch.error', function($event) use($rollbar) {
                    $exception = $event->getResult()->exception;
                    if ($exception) {
                        $rollbar->report_exception($exception);
                    }
                });
            }
            if (isset($rollbarConfig['errorhandler']) && true === $rollbarConfig['errorhandler']) {
                set_error_handler(array($rollbar, "report_php_error"));
            }
            if (isset($rollbarConfig['shutdownfunction']) && true === $rollbarConfig['shutdownfunction']) {
                register_shutdown_function( $this->shutdownHandler($rollbar));
            }
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

    /**
     * @param RollbarNotifier $rollbar
     * @return callable
     */
    protected function shutdownHandler($rollbar)
    {
        return function () use ($rollbar) {
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
        };
    }
}
