<?php
/**
 * Yassa Rollbar test case
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
 * @since      0.1.4
 */

namespace YassaRollbarTest\Options;

use YassaRollbarTest\TestCase;

/**
 * Test for RollbarNotifierFactory class
 *
 * @package YassaRollbarTest\Factory
 */
class RollbarNotifierFactoryTest extends TestCase
{
    public function testModuleOptions()
    {
        $options = $this->getServiceLocator()->get('RollbarNotifier');
        $this->assertInstanceOf('RollbarNotifier', $options);
    }
}
