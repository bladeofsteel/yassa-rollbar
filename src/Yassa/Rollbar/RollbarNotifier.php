<?php

namespace Yassa\Rollbar;

use Rollbar\Payload\Level;
use Rollbar\Rollbar;

/**
 * Class RollbarNotifier
 * @package Yassa\Rollbar
 * Backward compatibility class implementing methods deprecated at Rollbar
 */
class RollbarNotifier extends Rollbar
{
    /**
     * @param \Exception $exc Exception to be logged
     * @param array $extra_data Additional data to be logged with the exception
     * @param array $payload_data This is deprecated as of v1.0.0 and remains for
     * backwards compatibility. The content fo this array will be merged with
     * $extra_data.
     *
     * @return string uuid
     */
    public static function report_exception($exc, $extra_data = null, $payload_data = null)
    {
        if ($payload_data) {
            $extra_data = array_merge($extra_data, $payload_data);
        }
        return self::log(Level::error(), $exc, $extra_data)->getUuid();
    }

    /**
     * @param string $message Message to be logged
     * @param string|Level::error() $level One of the values in \Rollbar\Payload\Level::$values
     * @param array $extra_data Additional data to be logged with the exception
     * @param array $payload_data This is deprecated as of v1.0.0 and remains for
     * backwards compatibility. The content fo this array will be merged with
     * $extra_data.
     *
     * @return string uuid
     */
    public static function report_message($message, $level = null, $extra_data = null, $payload_data = null)
    {
        $level = $level ? Level::fromName($level) : Level::error();
        if ($payload_data) {
            $extra_data = array_merge($extra_data, $payload_data);
        }
        return self::log($level, $message, $extra_data)->getUuid();
    }

    /**
     * Catch any fatal errors that are causing the shutdown
     */
    public static function report_fatal_error()
    {
        self::fatalHandler();
    }

    /**
     * This function must return false so that the default php error handler runs
     */
    public static function report_php_error($errno, $errstr, $errfile, $errline)
    {
        self::errorHandler($errno, $errstr, $errfile, $errline);
        return false;
    }
}
