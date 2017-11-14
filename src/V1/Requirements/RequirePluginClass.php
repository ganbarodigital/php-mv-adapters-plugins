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
use GanbaroDigital\AdaptersAndPlugins\V1\Exceptions\NoSuchPluginClass;
use GanbaroDigital\AdaptersAndPlugins\V1\Exceptions\NotAPluginClass;
use GanbaroDigital\AdaptersAndPlugins\V1\Helpers;
use GanbaroDigital\AdaptersAndPlugins\V1\PluginTypes\PluginClass;
use GanbaroDigital\AdaptersAndPlugins\V1\PluginTypes\PluginProvider;
use GanbaroDigital\Defensive\V1\Interfaces\Requirement;
use GanbaroDigital\MissingBits\TypeInspectors\GetPrintableType;

/**
 * make sure that the plugin provides the targeted class
 */
class RequirePluginClass implements Requirement
{
    /**
     * which partial class are we looking for?
     * @var string
     */
    private $partialClassName;

    /**
     * create a new Requirement
     *
     * @param string $partialClassName
     *        the class we want to call inside the plugin
     */
    public function __construct(string $partialClassName)
    {
        $this->partialClassName = $partialClassName;
    }

    /**
     * create a new Requirement
     *
     * @param string $partialClassName
     *        the class we want to call inside the plugin
     * @return RequirePluginClass
     */
    public static function apply(string $partialClassName)
    {
        return new self($partialClassName);
    }

    /**
     * make sure that the plugin provides the targeted class
     *
     * @param  PluginProvider $pluginProvider
     *         the plugin that will provide the class we want
     * @return void
     * @throws NoSuchPluginClass
     *         if the plugin does not provide the class you are targeting
     * @throws NotAPluginClass
     *         if the targetted class does exist, but does not implement
     *         the PluginClass interface
     */
    public function to($pluginProvider, $fieldOrVarName = 'plugin')
    {
        // make sure we have a plugin provider to work with
        RequirePluginProvider::apply()->to($pluginProvider);

        // we have to do this here ... because we can be apply()ed to
        // multiple plugin providers
        $pluginClassName = Helpers\BuildTargetClassName::using($pluginProvider, $this->partialClassName);

        // does the target class exist?
        if (!class_exists($pluginClassName)) {
            throw NoSuchPluginClass::newFromInputParameter($pluginClassName, 'pluginClassName', [
                'pluginName' => GetPrintableType::of($pluginProvider),
            ]);
        }

        // is the target class compatible?
        if (!Checks\IsPluginClass::check($pluginClassName)) {
            throw NotAPluginClass::newFromInputParameter($pluginClassName, 'pluginClassName', [
                'pluginName' => GetPrintableType::of($pluginProvider),
            ]);
        }

        // all done
    }

    /**
     * make sure that the plugin provides the targeted class
     *
     * @param  PluginProvider $pluginProvider
     *         the plugin that will provide the class we want
     * @return void
     * @throws NoSuchPluginClass
     *         if the plugin does not provide the class you are targeting
     * @throws NotAPluginClass
     *         if the targetted class does exist, but does not implement
     *         the PluginClass interface
     */
    public function __invoke($pluginProvider, $fieldOrVarName = 'plugin')
    {
        $this->to($pluginProvider, $fieldOrVarName);
    }

    /**
     * make sure that the plugin provides the targeted class
     *
     * @param  PluginProvider $pluginProvider
     *         the plugin that will provide the class we want
     * @return void
     * @throws NoSuchPluginClass
     *         if the plugin does not provide the class you are targeting
     * @throws NotAPluginClass
     *         if the targetted class does exist, but does not implement
     *         the PluginClass interface
     */
    public function inspect($pluginProvider, $fieldOrVarName = 'plugin')
    {
        $this->to($pluginProvider, $fieldOrVarName);
    }
}