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
 * @version    0.1.4
 * @since      0.1.3
 */

namespace YassaRollbarTest\Options;

use Yassa\Rollbar\Options\ModuleOptions;
use YassaRollbarTest\TestCase;

/**
 * Test for ModuleOptions class
 *
 * @package YassaRollbarTest\Options
 */
class ModuleOptionsTest extends TestCase
{
    /**
     * @var \Yassa\Rollbar\Options\ModuleOptions
     */
    public static $moduleOptions;

    public function setUp()
    {
        if (self::$moduleOptions === null) {
            $config = include(__DIR__ . '/_files/module.yassa.rollbar.test.php');
            self::$moduleOptions = new ModuleOptions($config['yassa_rollbar']);
        }
    }

    /**
     * @dataProvider provider
     */
    public function testGettingModuleOptions($key, $expected)
    {
        $this->assertEquals($expected, self::$moduleOptions->$key);
    }

    public function testDefaultValuesOfModuleOptions()
    {
        $options = new ModuleOptions(array());
        $this->assertEquals(false, $options->enabled);
        $this->assertEquals(
            array('passwd', 'password', 'secret', 'confirm_password', 'password_confirmation'),
            $options->scrub_fields
        );
        $this->assertEquals(1024, $options->max_errno);
    }

    public function provider()
    {
        $config = include(__DIR__ . '/_files/module.yassa.rollbar.test.php');
        $result = array();
        foreach ($config['yassa_rollbar'] as $k => $value) {
            $result[] = array($k, $value);
        }

        return $result;
    }
}
