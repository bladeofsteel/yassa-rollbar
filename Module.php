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
 * @version    0.3.0
 * @since      0.1.0
 */

namespace Yassa\Rollbar;

use Rollbar\Payload\Level;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\MvcEvent;
use Zend\Http\Response;
use ZF\ApiProblem\ApiProblemResponse;

/**
 * Class Module
 *
 * @package Yassa\Rollbar
 */
class Module implements AutoloaderProviderInterface, ConfigProviderInterface
{
    public function onBootstrap(MvcEvent $event)
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
                $eventManager->attach(MvcEvent::EVENT_DISPATCH_ERROR, function(MvcEvent $event) use ($rollbar) {
                    $exception = $event->getResult()->exception ?? $event->getParam("exception");
                    if ($exception) {
                        $rollbar->report_exception($exception);

                        $content = json_encode(['Error' => 'Fatal error. Please try again later.']);
                        $response = new Response();
                        $response->setStatusCode(Response::STATUS_CODE_500);
                        $response->getHeaders()->addHeaders(['Content-type:application/json']);
                        $response->setContent($content);
                        $event->setResult($response);
                    }
                });
            }
            if ($options->errorhandler) {
                set_error_handler(array($rollbar, "report_php_error"));
            }
            if ($options->shutdownfunction) {
                register_shutdown_function($this->shutdownHandler($rollbar));
            }
            if ($options->catch_apigility_errors) {
                $eventManager = $application->getEventManager();
                $eventManager->attach(MvcEvent::EVENT_FINISH, function (MvcEvent $event) use ($rollbar) {
                    $result = $event->getResult();
                    if ($result instanceof ApiProblemResponse) {
                        $problem = $result->getApiProblem();
                        $problem->setDetailIncludesStackTrace(true);
                        $message = $problem->toArray();
                        $message['trace'] = json_encode($message['trace']);
                        $rollbar->report_message($message['title'] . " : " . $message['detail'], Level::error(), $message['trace']);

                        $problem->setDetailIncludesStackTrace(false);
                        $message = $problem->toArray();
                        $content = json_encode(['Error' => $message['title']]);
                        $response = new Response();
                        $response->setStatusCode(Response::STATUS_CODE_500);
                        $response->getHeaders()->addHeaders(['Content-type:application/json']);
                        $response->setContent($content);
                        $event->setResponse($response);
                    }
                });
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
     * @param  RollbarNotifier $rollbar
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
        };
    }
}
