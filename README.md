yassa-rollbar
=============

[![Build Status](https://travis-ci.org/bladeofsteel/yassa-rollbar.png?branch=master)](https://travis-ci.org/bladeofsteel/yassa-rollbar)&nbsp;[![Dependency Status](https://www.versioneye.com/user/projects/518fd6feb1e3ae00020014a1/badge.png)](https://www.versioneye.com/user/projects/518fd6feb1e3ae00020014a1)

This is ZF3 module that implements the notifier for Rollbar v.1.0. Catches and reports
exceptions to [Rollbar.com](https://rollbar.com/) for alerts, reporting, and analysis.

Requirements
------------

* [Zend Framework 3](https://github.com/zendframework) 
* [Rollbar v.1.0](https://github.com/rollbar/rollbar-php)

Installation
------------

### By cloning project

1. Install the [rollbar-php](https://github.com/rollbar/rollbar-php) by cloning it into `./vendor/`.
2. Clone this project into your `./vendor/` directory.

### With composer

1. Add this project in your composer.json:

    ```json
    "repositories": [
        {
            "type": "git",
            "url": "https://github.com/ProspectOne/yassa-rollbar"
        },
    ],
    ```
    ...
    ```json
    "require": {
        "prospect-one/yassa-rollbar": "dev-master"
    }
    ```

2. Install this package by running the command:

    ```bash
    $ php composer.phar update
    ```

Post installation
-----------------

1. Enabling it in your `application.config.php`file.

    ```php
    <?php
    return array(
        'modules' => array(
            'Yassa\Rollbar', // must be added as the first module
            // ...
        ),
        // ...
    );
    ```

2. Copy `config/module.yassa.rollbar.global.php.dist` in `project/directory/config/autoload/` and
    remove `.dist` extension.

Options
-------

The following options are available at that configuration file:

Yassa options:
- **enabled** - Switch On/Off module
- **errorhandler** - Register Rollbar as an error handler to log PHP errors
- **exceptionhandler** - Register Rollbar as an exception handler to log PHP exceptions
- **shutdownfunction** - Register Rollbar as an shutdown function

Rollbar 1.0 options, full list can be found at: [rollbar-php Configuration references](https://github.com/rollbar/rollbar-php#configuration-reference) :

- **access_token** - Your project access token
- **base_api_url** - The base API url to post to. (default: https://api.rollbar.com/api/1/)
- **branch** - Name of the checked-out branch.
- **capture_error_stacktraces** - Record full stacktraces for PHP errors. (default: true)
- **environment** - Environment name. Any string up to 255 chars is OK. For best results, use
  "production" for your production environment. (default: production)
- **error_sample_rates** - Associative array mapping PHP error numbers to sample rates.
  Sample rates are ratio out of 1, e.g. 0 is "never report", 1 is "always report", and 0.1 is
  "report 10% of the time". Sampling is done on a per-error basis. (default: array(), meaning
  all errors are reported.)
- **host** - Server hostname. (default: null, which will defer to a call to gethostname()
  (or php_uname('n') if that function does not exist))
- **logger** - An object with a log($level, $message) method. Will be used by RollbarNotifier to log messages.
  errors E_USER_NOTICE or higher. (default: -1 (report all errors))
- **person** - An associative array describing the currently-logged-in user.
  Required: id, optional: username, email. All values are strings.
- **person_fn** - A function reference (string, etc. - anything that
  [call_user_func](http://php.net/call_user_func) can handle) returning an
  array like the one for 'person'
- **root** - Absolute path to the root of your application, not including the final /.
- **scrub_fields** - Array of field names to scrub out of POST. Values will be
  replaced with astrickses. If overridiing, make sure to list all fields you want
  to scrub, not just fields you want to add to the default. Param names are
  converted to lowercase before comparing against the scrub list. (default:
  `array('passwd', 'password', 'secret', 'confirm_password', 'password_confirmation')`)
- **shift_function** - Whether to shift function names in stack traces down one frame,
  so that the function name correctly reflects the context of each frame. (default: true)
- **timeout** - Request timeout for posting to Rollbar, in seconds. (default: 3)
