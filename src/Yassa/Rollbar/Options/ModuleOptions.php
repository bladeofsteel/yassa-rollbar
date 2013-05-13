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
 * @version    0.2.0
 * @since      0.1.3
 */

namespace Yassa\Rollbar\Options;

use iRollbarLogger;
use Zend\Stdlib\AbstractOptions;

/**
 * Store of module options
 *
 * @package Yassa\Rollbar\Options
 *
 * @property bool $enabled Enabled module or not
 * @property string $access_token Project server-side access token
 * @property string $client_access_token Project client-side access token
 * @property bool $exceptionhandler Register Rollbar as an exception handler to log PHP exceptions
 * @property bool $errorhandler Register Rollbar as an error handler to log PHP errors
 * @property bool $shutdownfunction Register Rollbar as an shutdown function
 * @property string $base_api_url The base api url to post to (default 'https://api.rollbar.com/api/1/')
 * @property int $batch_size Flush batch early if it reaches this size. default: 50
 * @property bool $batched True to batch all reports from a single request together. default true.
 * @property string $branch Name of the current branch (default 'master')
 * @property bool $capture_error_backtraces Record full stacktraces for PHP errors. default: true
 * @property string $environment Environment name, e.g. 'production' or 'development'
 * @property array $error_sample_rates Associative array mapping error numbers to sample rates
 * @property string $handler Either "blocking" (default) or "agent". "blocking" uses curl to send
 *                           requests immediately; "agent" writes a relay log to be consumed by rollbar-agent.
 * @property string $agent_log_location Path to the directory where agent relay log files should be written
 * @property stirng $host Server hostname
 * @property iRollbarLogger $logger An object that has a log($level, $message) method
 * @property int $max_errno Max PHP error number to report. e.g. 1024 will ignore all errors above E_USER_NOTICE
 * @property array $person An associative array containing data about the currently-logged in user
 * @property string|array|callable $person_fn Callable Function reference returning an array like the one for 'person'
 * @property string $root Path to your project's root dir
 * @property array $scrub_fields Array of field names to scrub out of POST
 * @property bool $shift_function Whether to shift function names in stack traces down one frame
 * @property int $timeout Request timeout for posting to rollbar, in seconds. default 3
 */
class ModuleOptions extends AbstractOptions
{
    const API_URL = 'https://api.rollbar.com/api/1/';

    /**
     * @var bool Enabled module or not
     */
    protected $enabled = false;
    /**
     * @var string project server-side access token
     */
    protected $access_token = '';
    /**
     * @var string project client-side access token
     */
    protected $client_access_token = '';
    /**
     * @var string The base api url to post to (default 'https://api.rollbar.com/api/1/')
     */
    protected $base_api_url = self::API_URL;
    /**
     * @var int Flush batch early if it reaches this size. default: 50
     */
    protected $batch_size = 50;
    /**
     * @var bool True to batch all reports from a single request together. default true.
     */
    protected $batched = true;
    /**
     * @var string Name of the current branch (default 'master')
     */
    protected $branch = 'master';
    /**
     * @var bool record full stacktraces for PHP errors. default: true
     */
    protected $capture_error_backtraces = true;
    /**
     * @var string Environment name, e.g. 'production' or 'development'
     */
    protected $environment = '';
    /**
     * @var array Associative array mapping error numbers to sample rates
     */
    protected $error_sample_rates = array();
    /**
     * @var string Either "blocking" (default) or "agent". "blocking" uses curl to send
     *             requests immediately; "agent" writes a relay log to be consumed by rollbar-agent.
     */
    protected $handler = "blocking";
    /**
     * @var string Path to the directory where agent relay log files should be written
     */
    protected $agent_log_location = '/var/www';
    /**
     * @var string Server hostname. Default: null, which will result in a call to `gethostname()`)
     */
    protected $host;
    /**
     * @var iRollbarLogger An object that has a log($level, $message) method
     */
    protected $logger;
    /**
     * @var int Max PHP error number to report. e.g. 1024 will ignore all errors
     *          above E_USER_NOTICE. default: 1024 (ignore E_STRICT and above)
     */
    protected $max_errno = 1024;
    /**
     * @var array An associative array containing data about the currently-logged in user.
     *            Required: 'id', optional: 'username', 'email'. All values are strings.
     * @todo Replace array by object
     */
    protected $person = array();
    /**
     * @vara callable Function reference (string, etc. - anything that
     *                [call_user_func()](http://php.net/call_user_func) can handle) returning
     *                an array like the one for 'person'
     */
    protected $person_fn;
    /**
     * @var string Path to your project's root dir
     */
    protected $root;
    /**
     * @var array Array of field names to scrub out of POST
     *
     * Values will be replaced with astrickses. If overridiing, make sure to list all fields you want to scrub,
     * not just fields you want to add to the default. Param names are converted
     * to lowercase before comparing against the scrub list.
     * default: ('passwd', 'password', 'secret', 'confirm_password', 'password_confirmation')
     */
    protected $scrub_fields = array('passwd', 'password', 'secret', 'confirm_password', 'password_confirmation');
    /**
     * @var bool Whether to shift function names in stack traces down one frame, so that the
     *           function name correctly reflects the context of each frame. default: true.
     */
    protected $shift_function;
    /**
     * @var int Request timeout for posting to rollbar, in seconds. default 3
     */
    protected $timeout = 3;
    /**
     * @var bool Register Rollbar as an exception handler to log PHP exceptions
     */
    protected $exceptionhandler;
    /**
     * @var bool Register Rollbar as an error handler to log PHP errors
     */
    protected $errorhandler;
    /**
     * @var bool Register Rollbar as an shutdown function
     */
    protected $shutdownfunction;

    /**
     * {@inheridoc}
     */
    public function __set($key, $value)
    {
        if (!property_exists(__CLASS__, $key)) {
            throw new Exception\InvalidArgumentException (
                'The option "' . $key . '" does not exists'
            );
        }

        $this->{$key} = $value;
    }

    /**
     * {@inheridoc}
     */
    public function __get($key)
    {
        if (!property_exists(__CLASS__, $key)) {
            throw new Exception\InvalidArgumentException (
                'The option "' . $key . '" does not exists'
            );
        }

        return $this->{$key};
    }
}
