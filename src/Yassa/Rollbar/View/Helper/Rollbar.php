<?php
/**
 * View helper
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
 * @version    0.2.1
 * @since      0.2.1
 */

namespace Yassa\Rollbar\View\Helper;

use Yassa\Rollbar\Options\ModuleOptions;
use Zend\View\Helper\AbstractHelper;

class Rollbar extends AbstractHelper
{
    /**
     * \Yassa\Rollbar\Options\ModuleOptions
     */
    protected $options;

    /**
     * Constructor
     *
     * @params \RollbarNotifier $rollbar
     */
    public function __construct(ModuleOptions $options)
    {
        $this->options = $options;
    }

    /**
     * @return string
     */
    public function __invoke()
    {
        $script[] = sprintf('var _rollbarParams = {"server.environment": "%s"};', $this->options->environment);
        $script[] = '_rollbarParams["notifier.snippet_version"] = "2";';
        $script[] = sprintf('var _rollbar=["%s", _rollbarParams];', $this->options->client_access_token);
        $script[] = 'var _ratchet=_rollbar;';
        $script[] = '(function(w,d){w.onerror=function(e,u,l){_rollbar.push({_t:\'uncaught\',e:e,u:u,l:l});};';
        $script[] = 'var i=function(){var s=d.createElement("script");var f=d.getElementsByTagName("script")[0];';
        $script[] = 's.src="//d37gvrvc0wt4s1.cloudfront.net/js/1/rollbar.min.js";';
        $script[] = 's.async=!0;f.parentNode.insertBefore(s,f);};';
        $script[] = 'if(w.addEventListener){w.addEventListener("load",i,!1);}';
        $script[] = 'else{w.attachEvent("onload",i);}})(window,document);';

        return sprintf('<script>%s</script>', implode("", $script));
    }
}
