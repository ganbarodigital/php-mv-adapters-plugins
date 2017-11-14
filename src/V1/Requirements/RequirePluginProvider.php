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
 * @package   AdaptersAndPlugins\V1\Requirements
 * @author    Stuart Herbert <stuherbert@ganbarodigital.com>
 * @copyright 2017-present Ganbaro Digital Ltd www.ganbarodigital.com
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link      http://ganbarodigital.github.io/php-mv-adapters-plugins
 */

namespace GanbaroDigital\AdaptersAndPlugins\V1\Requirements;

use GanbaroDigital\AdaptersAndPlugins\V1\Checks;
use GanbaroDigital\AdaptersAndPlugins\V1\Exceptions\NotAPluginProvider;
use GanbaroDigital\Defensive\V1\Interfaces\Requirement;
use GanbaroDigital\MissingBits\TypeInspectors\GetPrintableType;

/**
 * make sure that we have a PluginProvider to work with
 */
class RequirePluginProvider implements Requirement
{
    /**
     * create a new Requirement
     *
     * @return RequirePluginProvider
     */
    public static function apply()
    {
        return new self();
    }

    /**
     * make sure that we have a PluginProvider
     *
     * @param  mixed $pluginProvider
     *         the object we are checking
     * @return void
     * @throws NotAPluginProvider
     *         if $pluginProvider isn't actually a plugin provider
     */
    public function to($pluginProvider, $fieldOrVarName = 'pluginProvider')
    {
        // what do we have?
        if (Checks\IsPluginProvider::check($pluginProvider)) {
            // we have a plugin provider :)
            return;
        }

        // whatever it is, it isn't a plugin provider ...
        throw NotAPluginProvider::newFromInputParameter($pluginProvider, 'pluginProvider', [
            'pluginName' => GetPrintableType::of($pluginProvider),
        ]);
    }

    /**
     * make sure that we have a PluginProvider
     *
     * @param  mixed $pluginProvider
     *         the object we are checking
     * @return void
     * @throws NotAPluginProvider
     *         if $pluginProvider isn't actually a plugin provider
     */
    public function __invoke($pluginProvider, $fieldOrVarName = 'pluginProvider')
    {
        $this->to($pluginProvider, $fieldOrVarName);
    }

    /**
     * make sure that we have a PluginProvider
     *
     * @param  mixed $pluginProvider
     *         the object we are checking
     * @return void
     * @throws NotAPluginProvider
     *         if $pluginProvider isn't actually a plugin provider
     */
    public function inspect($pluginProvider, $fieldOrVarName = 'pluginProvider')
    {
        $this->to($pluginProvider, $fieldOrVarName);
    }
}