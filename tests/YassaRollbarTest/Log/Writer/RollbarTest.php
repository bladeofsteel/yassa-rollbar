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
 * @version    0.2.0
 * @since      0.2.0
 */

namespace YassaRollbarTest\Log\Writer;

use DateTime;
use Yassa\Rollbar\Log\Writer\Rollbar;
use YassaRollbarTest\TestCase;

/**
 * Class for testing Rollbar log writer
 *
 * @package YassaRollbarTest\Log\Writer
 */
class RollbarTest extends TestCase
{
    public function testCallingWriteShouldTransferRequestToRollbar()
    {
        $message = array(
            'message' => 'test message',
            'priorityName' => 'INFO',
            'priority' => 6,
            'timestamp' => '2007-04-06T07:16:37-07:00',
        );

        $mock = $this->getMock('\RollbarNotifier', array(), array(), '', false);
        $mock->expects($this->once())
             ->method('report_message')
             ->with(
                $this->equalTo($message['message']),
                $this->equalTo($message['priorityName']),
                $this->equalTo(array('timestamp' => $message['timestamp']))
            );

        $writer = new Rollbar($mock);
        $writer->write($message);
    }

    public function testExtraParamsShouldBeTransferedToRolbar()
    {
        $message = array(
            'message' => 'test message',
            'priorityName' => 'INFO',
            'priority' => 6,
            'timestamp' => '2007-04-06T07:16:37-07:00',
            'extra_param_1' => 'test param',
            'extra_param_2' => 100,
        );

        $mock = $this->getMock('\RollbarNotifier', array(), array(), '', false);
        $mock->expects($this->once())
            ->method('report_message')
            ->with(
                $this->equalTo($message['message']),
                $this->equalTo($message['priorityName']),
                $this->equalTo(array(
                        'timestamp' => $message['timestamp'],
                        'extra_param_1' => 'test param',
                        'extra_param_2' => 100,
                    ))
            );

        $writer = new Rollbar($mock);
        $writer->write($message);
    }

    public function testDateTimeShouldConvertingToStringBeforeCallRollbar()
    {
        date_default_timezone_set('Europe/Moscow');
        $message = array(
            'message' => 'test message',
            'priorityName' => 'INFO',
            'priority' => 6,
            'timestamp' => DateTime::createFromFormat(DateTime::W3C, '2007-04-06T07:16:37-07:00'),
        );

        $mock = $this->getMock('\RollbarNotifier', array(), array(), '', false);
        $mock->expects($this->once())
            ->method('report_message')
            ->with(
                $this->equalTo($message['message']),
                $this->equalTo($message['priorityName']),
                $this->equalTo(array('timestamp' => '2007-04-06T07:16:37-07:00'))
            );

        $writer = new Rollbar($mock);
        $writer->write($message);
    }
}
