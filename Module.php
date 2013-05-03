<?php
/**
 * Module class
 *
 * Copyright 2013 Oleg Lobach <oleg@lobach.info>
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  you may not use this file except in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 *
 * @copyright  Copyright (c) 2013 Oleg Lobach <oleg@lobach.info>
 * @license    Apache License V2 <http://www.apache.org/licenses/LICENSE-2.0.html>
 * @author     Oleg Lobach <oleg@lobach.info>
 * @version    0.1.3
 * @since      0.1.0
 */

namespace Yassa\Rollbar;

use RollbarNotifier;
use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

/**
 * Class Module
 *
 * @package Yassa\Rollbar
 */
class Module implements AutoloaderProviderInterface, ConfigProviderInterface
{
    public function onBootstrap(EventInterface $event)
    {
        /** @var \Zend\Mvc\ApplicationInterface $application */
        $application = $event->getApplication();

        /** @var \Yassa\Rollbar\Options\ModuleOptions $options */
        $options = $application->getServiceManager()->get('Yassa\Rollbar\Options\ModuleOptions');

        if ($options->enabled) {
            /** @var RollbarNotifier $rollbar */
            $rollbar = $application->getServiceManager()->get('RollbarNotifier');

            if ($options->exceptionhandler) {
                set_exception_handler(array($rollbar, "report_exception"));

                $eventManager = $application->getEventManager();
                $eventManager->attach('dispatch.error', function($event) use($rollbar) {
                    $exception = $event->getResult()->exception;
                    if ($exception) {
                        $rollbar->report_exception($exception);
                    }
                });
            }
            if ($options->errorhandler) {
                set_error_handler(array($rollbar, "report_php_error"));
            }
            if ($options->shutdownfunction) {
                register_shutdown_function( $this->shutdownHandler($rollbar));
            }
        }
    }

    /**
     * Returns configuration to merge with application configuration
     *
     * @return array|\Traversable
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * Return an array for passing to Zend\Loader\AutoloaderFactory.
     *
     * @return array
     */
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
