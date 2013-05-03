<?php
/**
 * Container for module options
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
 * @since      0.1.3
 */

namespace Yassa\Rollbar\Options;

use Zend\Stdlib\AbstractOptions;

/**
 * Store of module options
 *
 * @package Yassa\Rollbar\Options
 */
class ModuleOptions extends AbstractOptions
{
    protected $access_token;
    protected $base_api_url;
    protected $batch_size;
    protected $batched;
    protected $branch;
    protected $capture_error_backtraces;
    protected $environment;
    protected $error_sample_rates;
    protected $handler;
    protected $agent_log_location;
    protected $host;
    protected $logger;
    protected $max_errno;
    protected $person;
    protected $person_fn;
    protected $root;
    protected $scrub_fields;
    protected $shift_function;
    protected $timeout;
    protected $exceptionhandler;
    protected $errorhandler;
    protected $shutdownfunction;
}
