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
 * @version    0.3.0
 * @since      0.1.3
 */

namespace Yassa\Rollbar\Options;

use Rollbar\RollbarLogger;
use Zend\Stdlib\AbstractOptions;

/**
 * Store of module options
 *
 * @package Yassa\Rollbar\Options
 *
 * Yassa options:
 * @property bool $enabled Enabled module or not
 * @property bool $exceptionhandler Register Rollbar as an exception handler to log PHP exceptions
 * @property bool $errorhandler Register Rollbar as an error handler to log PHP errors
 * @property bool $shutdownfunction Register Rollbar as an shutdown function
 * @property bool $catch_apigility_errors Should we log ApiProblemResponse messages
 *
 * Rollbar 1.0 options:
 * @property string $access_token Project server-side access token
 * @property string $agent_log_location Path to the directory where agent relay log files should be written
 * @property string $base_api_url The base api url to post to (default 'https://api.rollbar.com/api/1/')
 * @property string $branch Name of the current branch (default 'master')
 * @property bool $capture_error_stacktraces Record full stacktraces for PHP errors. default: true
 * @property null|bool $checkIgnore Function called before sending payload to Rollbar, return true to stop the error from being sent to Rollbar
 * @property string|null $code_version The currently-deployed version of your code/application (e.g. a Git SHA). Should be a string.
 * @property bool $enable_utf8_sanitization Set it to false to disable running iconv on the payload, may be needed if there is invalid characters, and the payload is being destroy
 * @property string $environment Environment name, e.g. 'production' or 'development'
 * @property array $error_sample_rates Associative array mapping error numbers to sample rates
 * @property string $handler Either "blocking" (default) or "agent". "blocking" uses curl to send requests immediately; "agent" writes a relay log to be consumed by rollbar-agent.
 * @property string $host Server hostname
 * @property bool $include_error_code_context A boolean that indicates you wish to gather code context for instances of PHP Errors. This can take a while because it requires reading the file from disk, so it's off by default.
 * @property bool $include_exception_code_context A boolean that indicates you wish to gather code context for instances of PHP Exceptions. This can take a while because it requires reading the file from disk, so it's off by default.
 * @property string $included_errno A bitmask that includes all of the error levels to report.
 * @property RollbarLogger $logger An object that has a log($level, $message) method
 * @property array $person An associative array containing data about the currently-logged in user
 * @property string|array|callable $person_fn Callable Function reference returning an array like the one for 'person'
 * @property string $root Path to your project's root dir
 * @property array $scrub_fields Array of field names to scrub out of POST
 * @property bool $shift_function Whether to shift function names in stack traces down one frame
 * @property int $timeout Request timeout for posting to rollbar, in seconds. default 3
 * @property bool $report_suppressed Sets whether errors suppressed with '@' should be reported or not. Default: false
 * @property bool $use_error_reporting Sets whether to respect current `error_reporting()` level or not. Default: false
 * @property string|mixed $proxy Send data via a proxy server. E.g. Using a local proxy with no authentication.
 *
 * Deprecated and unused in Rollbar 1.0 (compatibility):
 * @property string $client_access_token Project client-side access token
 * @property int $batch_size Flush batch early if it reaches this size. default: 50
 * @property bool $batched True to batch all reports from a single request together. default true.
 * @property bool $capture_error_backtraces Record full stacktraces for PHP errors. default: true
 * @property int $max_errno Max PHP error number to report. e.g. 1024 will ignore all errors above E_USER_NOTICE
 */
class ModuleOptions extends AbstractOptions
{
    /**
     * ToDo check corrrect url, because this one is incompatible with Rollbar - defined 'https://api.rollbar.com/api/1/item'
     * Unset at Factory
     */
    const API_URL = 'https://api.rollbar.com/api/1/';

    /**
     * @var bool Enabled module or not
     */
    protected $enabled = false;

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
     * @var string project server-side access token
     */
    protected $access_token = '';

    /**
     * @var string Path to the directory where agent relay log files should be written
     */
    protected $agent_log_location = '/var/www';

    /**
     * @var string The base api url to post to (default 'https://api.rollbar.com/api/1/')
     * For compatibility with Rollbar is unset in Factory
     * ToDo check correct url
     */
    protected $base_api_url = self::API_URL;

    /**
     * @var string Name of the current branch (default 'master')
     */
    protected $branch = 'master';

    /**
     * @var bool record full stacktraces for PHP errors. default: true
     */
    protected $capture_error_stacktraces = true;

    /**
     * @return null|bool
     * Function called before sending payload to Rollbar, return true to stop the error from being sent to Rollbar.
     * @param $isUncaught: boolean value set to true if the error was an uncaught exception.
     * @param $exception: a RollbarException instance that will allow you to get the message or exception
     * @param $payload: an array containing the payload as it will be sent to Rollbar. Payload schema can be found
     * at https://rollbar.com/docs/api/items_post/
     */
    protected $checkIgnore = null;

    /**
     * @var string|null The currently-deployed version of your code/application (e.g. a Git SHA). Should be a string.
     */
    protected $code_version = null;

    /**
     * @var bool Set it to false to disable running iconv on the payload, may be needed if there is invalid characters,
     * and the payload is being destroyed
     */
    protected $enable_utf8_sanitization = true;

    /**
     * @var string Environment name, e.g. 'production' or 'development'
     */
    protected $environment = '';

    /**
     * @var array Associative array mapping error numbers to sample rates
     */
    protected $error_sample_rates = [];

    /**
     * @var string Either "blocking" (default) or "agent". "blocking" uses curl to send
     *             requests immediately; "agent" writes a relay log to be consumed by rollbar-agent.
     */
    protected $handler = "blocking";

    /**
     * @var string Server hostname. Default: null, which will result in a call to `gethostname()`)
     */
    protected $host;

    /**
     * @var bool A boolean that indicates you wish to gather code context for instances of PHP Errors.
     * This can take a while because it requires reading the file from disk, so it's off by default.
     */
    protected $include_error_code_context = false;

    /**
     * @var bool A boolean that indicates you wish to gather code context for instances of PHP Exceptions.
     * This can take a while because it requires reading the file from disk, so it's off by default.
     */
    protected $include_exception_code_context = false;

    /**
     * @var string A bitmask that includes all of the error levels to report.
     * E.g. (E_ERROR \| E_WARNING) to only report E_ERROR and E_WARNING errors. This will be used in combination with `error_reporting()`
     * to prevent reporting of errors if `use_error_reporting` is set to `true`.
     * Default: (E_ERROR | E_WARNING | E_PARSE | E_CORE_ERROR | E_USER_ERROR | E_RECOVERABLE_ERROR)
     */
    protected $included_errno;

    /**
     * @var RollbarLogger An object that has a log($level, $message) method
     */
    protected $logger;

    /**
     * @var array An associative array containing data about the currently-logged in user.
     *            Required: 'id', optional: 'username', 'email'. All values are strings.
     */
    protected $person = array();

    /**
     * @var a callable Function reference (string, etc. - anything that
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
     * @var bool Sets whether errors suppressed with '@' should be reported or not
     */
    protected $report_suppressed = false;

    /**
     * @var bool Sets whether to respect current `error_reporting()` level or not
     */
    protected $use_error_reporting = false;

    /**
     * @var string|mixed Send data via a proxy server. E.g. Using a local proxy with no authentication
     * <?php $config['proxy'] = "127.0.0.1:8080"; ?>
     */
    protected $proxy;

    /**
     * @var string project client-side access token
     */
    protected $client_access_token = '';

    /**
     * @var int Flush batch early if it reaches this size. default: 50
     */
    protected $batch_size = 50;
    /**
     * @var bool True to batch all reports from a single request together. default true.
     */
    protected $batched = true;

    /**
     * @var int Max PHP error number to report. e.g. 1024 will ignore all errors
     *          above E_USER_NOTICE. default: 1024 (ignore E_STRICT and above)
     */
    protected $max_errno = 1024;

    /**
     * @var bool record full stacktraces for PHP errors. default: true
     */
    protected $capture_error_backtraces = true;

    /**
     * @var bool should we log ApiProblemResponse messages
     */
    protected $catch_apigility_errors = false;

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
