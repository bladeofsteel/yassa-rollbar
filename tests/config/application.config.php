<?php
return array(
    'modules' => array(
        'Yassa\Rollbar',
    ),
    'module_listener_options' => array(
        'module_paths' => array(
            '../../',
        ),
        'config_glob_paths' => array('config/autoload/{,*.}{global,local}.php'),
    ),
);
