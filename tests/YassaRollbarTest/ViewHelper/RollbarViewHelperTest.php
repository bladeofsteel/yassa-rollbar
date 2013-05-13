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
 * @version    0.2.1
 * @since      0.2.1
 */

namespace YassaRollbarTest\ViewHelper;

use Yassa\Rollbar\Options\ModuleOptions;
use Yassa\Rollbar\View\Helper\Rollbar;
use YassaRollbarTest\TestCase;

/**
 * Test for RollbarViewHelperTest class
 *
 * @package YassaRollbarTest\Factory
 */
class RollbarViewHelperTest extends TestCase
{
    public function testShouldReturnScript()
    {
        $params = array(
            'environment' => 'test',
            'client_access_token' => 'YOUR_ACCESS_TOKEN',
        );

        $mock = $this->getMock('\Yassa\Rollbar\Options\ModuleOptions', array(), array(), '', false);
        $i = -1;
        foreach ($params as $k => $v) {
            $mock->expects($this->at(++$i))
                 ->method('__get')
                 ->with( $this->equalTo($k))
                 ->will($this->returnValue($v));
        }

        $helper = new Rollbar($mock);
        $result = $helper();
        $this->assertStringEqualsFile(__DIR__ . '/_files/script.txt', $result);
    }
}
