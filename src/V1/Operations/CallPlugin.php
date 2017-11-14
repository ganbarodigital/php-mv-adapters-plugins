<?php

/**
 * Copyright (c) 2017-present Ganbaro Digital Ltd
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the names of the copyright holders nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @category  Libraries
 * @package   AdaptersAndPlugins\V1\Operations
 * @author    Stuart Herbert <stuherbert@ganbarodigital.com>
 * @copyright 2017-present Ganbaro Digital Ltd www.ganbarodigital.com
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link      http://ganbarodigital.github.io/php-mv-adapters-plugins
 */

namespace GanbaroDigital\AdaptersAndPlugins\V1\Operations;

use GanbaroDigital\AdaptersAndPlugins\V1\Exceptions\NoSuchPluginClass;
use GanbaroDigital\AdaptersAndPlugins\V1\Exceptions\NoSuchMethodOnPluginClass;
use GanbaroDigital\AdaptersAndPlugins\V1\Helpers;
use GanbaroDigital\AdaptersAndPlugins\V1\PluginTypes\PluginProvider;
use GanbaroDigital\AdaptersAndPlugins\V1\Requirements\RequirePluginClass;
use GanbaroDigital\AdaptersAndPlugins\V1\Requirements\RequirePluginClassMethod;

/**
 * call a class that's provided by a specific plugin
 */
class CallPlugin
{
    /**
     * call a class that's provided by a specific plugin
     *
     * @param  PluginProvider $pluginProvider
     *         the plugin that will provide the class we want
     * @param  string $plugin
     *         subpath to the class we want to call
     * @param  string $method
     *         the method on $plugin that we want to call
     * @param  ... $params
     *         variadic of the parameters to pass to the method
     * @return mixed
     *         whatever the method returns (if anything)
     * @throws NoSuchPluginClass
     *         if the plugin does not provide the class you are targeting
     * @throws NotAPluginClass
     *         if the plugin does provide the class you are targeting, but
     *         it is doesn't implement PluginClass
     * @throws NoSuchMethodOnPluginClass
     *         if the plugin's class does not provide the method you are
     *         trying to call
     */
    public static function using(PluginProvider $pluginProvider, string $plugin, string $method, ...$params)
    {
        // robustness checks!!
        //
        // we use multiple checks here (despite the performance impact)
        // because this provides the clearest errors if the caller has
        // made a mistake
        RequirePluginClass::apply($plugin)->to($pluginProvider);
        RequirePluginClassMethod::apply($plugin, $method)->to($pluginProvider);

        // if we get to here, we know that we can attempt the call
        //
        // what happens after this is down to the class we are calling,
        // and whether or not we've been given compatible parameters
        $className = Helpers\BuildTargetClassName::using($pluginProvider, $plugin);
        return call_user_func_array([$className, $method], $params);
    }
}