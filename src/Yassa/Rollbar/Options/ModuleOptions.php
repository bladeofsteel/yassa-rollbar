<?php
namespace Yassa\Rollbar\Options;

use Zend\Stdlib\AbstractOptions;

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
