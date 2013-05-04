<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'Yassa\Rollbar\Options\ModuleOptions' => 'Yassa\Rollbar\Options\ModuleOptionsFactory',
            'RollbarNotifier'                     => 'Yassa\Rollbar\Factory\RollbarNotifierFactory',
            'Yassa\Rollbar\Log\Writer\Rollbar'    => 'Yassa\Rollbar\Factory\RollbarLogWriterFactory',
        ),
    ),
);
