<?php
/**
 * Yassa Rollbar test suite
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
 * @since      0.1.3
 */

namespace YassaRollbarTest;

use Zend\ServiceManager\ServiceManager;
use Zend\Mvc\Service\ServiceManagerConfig;

chdir(__DIR__);

while (!file_exists('config/application.config.php')) {
    throw new \RuntimeException(
        'Unable to locate "config/application.config.php":'
        . ' is in a subdir of your application skeleton?'
    );
}

// Setup autoloaders
$loader = include('../vendor/autoload.php');
if (!$loader) {
    throw new \RuntimeException(
        'vendor/autoload.php could not be found. '
        . 'Did you run php composer.phar --dev install?'
    );
}
$loader->addClassMap(include(__DIR__ . '/autoload_classmap.php'));

// Get application stack configuration
$configuration = include 'config/application.config.php';
$configuration['module_listener_options']['config_glob_paths'][] = __DIR__ . '/config/{,*.}{global,local}.php';

// Setup service manager
$serviceManager = new ServiceManager(new ServiceManagerConfig(@$configuration['service_manager'] ?: array()));
$serviceManager->setService('ApplicationConfig', $configuration);
$serviceManager->setFactory('ServiceListener', 'Zend\Mvc\Service\ServiceListenerFactory');
$serviceManager->get('ModuleManager')->loadModules();
TestCase::setServiceLocator($serviceManager);
