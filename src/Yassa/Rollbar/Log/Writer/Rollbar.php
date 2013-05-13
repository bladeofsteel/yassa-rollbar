<?php
/**
 * Rollbar writer for Zend\Log
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

namespace Yassa\Rollbar\Log\Writer;

use DateTime;
use RollbarNotifier;
use Zend\Log\Formatter\FormatterInterface;
use Zend\Log\Writer\AbstractWriter;

/**
 * Rollbar log writer.
 */
class Rollbar extends AbstractWriter
{
    /**
     * \RollbarNotifier
     */
    protected $rollbar;

    /**
     * Constructor
     *
     * @params \RollbarNotifier $rollbar
     */
    public function __construct(RollbarNotifier $rollbar)
    {
        $this->rollbar = $rollbar;
    }

    /**
     * This writer does not support formatting.
     *
     * @param  string|FormatterInterface $formatter
     * @return WriterInterface
     */
    public function setFormatter($formatter)
    {
        return $this;
    }

    /**
     * Write a message to the log.
     *
     * @param  array $event Event data
     * @return void
     */
    protected function doWrite(array $event)
    {
        if (isset($event['timestamp']) && $event['timestamp'] instanceof DateTime) {
            $event['timestamp'] = $event['timestamp']->format(DateTime::W3C);
        }
        $extra = array_diff_key($event, array('message'=>'', 'priorityName' => '', 'priority' => 0));

        $this->rollbar->report_message($event['message'], $event['priorityName'], $extra);
    }
}
