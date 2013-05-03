<?php
/**
 * Rollbar Configuration
 *
 * If you have a ./config/autoload/ directory set up for your project, you can
 * drop this config file in it and change the values as you wish.
 */
$settings = array(
    /**
     * Enabled module or not
     */
    'enabled' => true,
    /**
     * your project access token
     */
    //'access_token' => '',

    /**
     * Register Rollbar as an exception handler to log PHP exceptions
     */
    //'exceptionhandler' => true,

    /**
     * Register Rollbar as an error handler to log PHP errors
     */
    //'errorhandler' => true,

    /**
     * Register Rollbar as an shutdown function
     */
    //'shutdownfunction' => true,

    /**
     * the base api url to post to (default 'https://api.rollbar.com/api/1/')
     */
    //'base_api_url' => '',

    /**
     * flush batch early if it reaches this size. default: 50
     */
    //'batch_size' => 50,

    /**
     * true to batch all reports from a single request together. default true.
     */
    //'batched' => true,

    /**
     * name of the current branch (default 'master')
     */
    //'branch' => 'master',

    /**
     * record full stacktraces for PHP errors. default: true.
     */
    //'capture_error_backtraces' => true,

    /**
     * environment name, e.g. 'production' or 'development'
     */
    //'environment' => '',

    /**
     * associative array mapping error numbers to sample rates.
     *
     * Sample rates are ratio out of 1, e.g. 0 is "never report", 1 is "always report",
     * and 0.1 is "report 10% of the time". Sampling is done on a per-error basis.
     * Default: empty array, meaning all errors are reported.
     */
    //'error_sample_rates' => array(),

    /**
     * either "blocking" (default) or "agent". "blocking" uses curl to send
     * requests immediately; "agent" writes a relay log to be consumed by rollbar-agent.
     */
    //'handler' => 'blocking',

    /**
     * Path to the directory where agent relay log files should be written.
     * Should not include final slash. Only used when handler is "agent".
     * Default: /var/www
     */
    //'agent_log_location' => '/var/www',

    /**
     * server hostname. Default: null, which will result in a call to `gethostname()`
     * (or `php_uname('n')` if that function does not exist)
     */
    //'host' => null,

    /**
     * an object that has a log($level, $message) method. If provided, will be used
     * by RollbarNotifier to log messages.
     */
    //'logger' => null,

    /**
     * max PHP error number to report. e.g. 1024 will ignore all errors
     * above E_USER_NOTICE. default: 1024 (ignore E_STRICT and above).
     */
    //'max_errno' => 1024,

    /**
     * an associative array containing data about the currently-logged in user.
     * Required: 'id', optional: 'username', 'email'. All values are strings.
     */
    //'person' => array(),

    /**
     * a function reference (string, etc. - anything
     * that [call_user_func()](http://php.net/call_user_func) can handle) returning
     * an array like the one for 'person'.
     */
    //'person_fn',

    /**
     * path to your project's root dir
     */
    //'root',

    /**
     * array of field names to scrub out of POST. Values will be replaced with
     * astrickses. If overridiing, make sure to list all fields you want to scrub,
     * not just fields you want to add to the default. Param names are converted
     * to lowercase before comparing against the scrub list.
     * default: ('passwd', 'password', 'secret', 'confirm_password', 'password_confirmation').
     */
    //'scrub_fields',

    /**
     * whether to shift function names in stack traces down one frame, so that the
     * function name correctly reflects the context of each frame. default: true.
     */
    //'shift_function' => true,

    /**
     * request timeout for posting to rollbar, in seconds. default 3.
     */
    //'timeout' => 3,
);

/**
 * You do not need to edit below this line
 */
return array(
    'yassa_rollbar' => $settings,
);
