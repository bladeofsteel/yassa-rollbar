<?php
/**
 * Factory for view helper
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
 * @since      0.3.0
 */

namespace Yassa\Rollbar\Factory;

use Yassa\Rollbar\View\Helper\Rollbar;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Factory for View\Helper\Rollbar class
 *
 * @package Yassa\Rollbar\Factory
 */
class RollbarViewHelperFactory implements FactoryInterface
{
    /**
     * {@inheritdocs}
     */
    public function createService(ServiceLocatorInterface $sl)
    {
        $options  = $sl->getServiceLocator()->get('Yassa\Rollbar\Options\ModuleOptions');

        return new Rollbar($options);
    }
}
