<?php

namespace Yassa\Rollbar\Factory;

use Interop\Container\ContainerInterface;
use Rollbar\Rollbar as RollbarNotifier;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Factory for RolbarNotifier class
 *
 * @package Yassa\Rollbar\Factory
 */
class RollbarNotifierFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return RollbarNotifier
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $options  = $container->get('Yassa\Rollbar\Options\ModuleOptions');

        /* Compatibility array, ToDo think of the best way to fit current yassa configs*/
        $opt = $options->toArray();
        $optRollbar = [
            'access_token' => $opt['access_token'],
            'agent_log_location' => $opt['agent_log_location'],
            //'base_api_url' => $opt['base_api_url'], is wrong at yassa config or causes 404
            'branch' => $opt['branch'],
            'capture_error_stacktraces' => $opt['capture_error_backtraces'],
            'checkIgnore' => $opt['checkIgnore'] ?? null,
            'code_version' => $opt['code_version'] ?? null,
            'enable_utf8_sanitization' => $opt['enable_utf8_sanitization'] ?? true,
            'environment' => $opt['environment'],
            'error_sample_rates' => $opt['error_sample_rates'],
            'handler' => $opt['handler'],
            'host' => $opt['host'],
            'include_error_code_context' => $opt['include_error_code_context'] ?? false,
            'include_exception_code_context' => $opt['include_exception_code_context'] ?? false,
            // 'included_errno' - shows bitmask, no reason to set it here
            'logger' => $opt['logger'],
            'person' => $opt['person'],
            'person_fn' => $opt['person_fn'],
            'root' => $opt['root'],
            'scrub_fields' => $opt['scrub_fields'],
            'shift_function' => $opt['shift_function'],
            'timeout' => $opt['timeout'],
            'report_suppressed' => $opt['report_suppressed'] ?? false,
            'use_error_reporting' => $opt['use_error_reporting'] ?? false,
            // 'proxy' - no need to set here
        ];

        $rb = new RollbarNotifier();
        $rb::init($optRollbar);
        return $rb;
    }
}
