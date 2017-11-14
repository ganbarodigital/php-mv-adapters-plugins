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

namespace GanbaroDigitalTest\AdaptersAndPlugins\V1\Requirements;

require_once(__DIR__ . "/../Fixtures/DummyPlugin.php");
require_once(__DIR__ . "/../Fixtures/Operations/DummyOperation.php");
require_once(__DIR__ . "/../Fixtures/Operations/NotAnOperation.php");

use GanbaroDigital\AdaptersAndPlugins\V1\Exceptions\NoSuchMethodOnPluginClass;
use GanbaroDigital\AdaptersAndPlugins\V1\Exceptions\NotAPluginClass;
use GanbaroDigital\AdaptersAndPlugins\V1\Helpers;
use GanbaroDigital\AdaptersAndPlugins\V1\Requirements\RequireMethodOnPluginClass;
use GanbaroDigitalTest\AdaptersAndPlugins\V1\Fixtures\DummyPlugin;
use GanbaroDigitalTest\AdaptersAndPlugins\V1\Fixtures\Operations\DummyOperation;
use GanbaroDigitalTest\AdaptersAndPlugins\V1\Fixtures\Operations\NotAnOperation;

/**
 * @coversDefaultClass GanbaroDigital\AdaptersAndPlugins\V1\Requirements\RequireMethodOnPluginClass
 */
class RequireMethodOnPluginClassTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @covers ::apply
     * @covers ::to
     * @covers ::inspect
     * @covers ::__invoke
     * @covers ::__construct
     */
    public function test_accepts_a_valid_plugin_class_method()
    {
        // ----------------------------------------------------------------
        // setup your test

        $provider = new DummyPlugin;
        $plugin = 'Operations\DummyOperation';
        $method = 'reflectBack';

        $unit = new RequireMethodOnPluginClass($plugin, $method);

        // ----------------------------------------------------------------
        // perform the change

        RequireMethodOnPluginClass::apply($plugin, $method)->to($provider);
        $unit($provider);
        $unit->inspect($provider);

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue(true);
    }

    /**
     * @covers ::apply
     * @covers ::to
     * @covers ::inspect
     * @covers ::__invoke
     * @covers ::__construct
     */
    public function test_throws_NoSuchMethodOnPluginClass_when_method_is_not_defined()
    {
        // ----------------------------------------------------------------
        // setup your test

        $provider = new DummyPlugin;
        $plugin = "Operations\\DummyOperation";
        $method = "methodDoesNotExist";

        $unit = new RequireMethodOnPluginClass($plugin, $method);

        $caught1 = false;
        $caught2 = false;
        $caught3 = false;

        // ----------------------------------------------------------------
        // perform the change
        //
        // we check all the different public methods here

        try {
            RequireMethodOnPluginClass::apply($plugin, $method)->to($provider);
        } catch (NoSuchMethodOnPluginClass $e) {
            $caught1 = true;
        }

        try {
            $unit($provider);
        } catch (NoSuchMethodOnPluginClass $e) {
            $caught2 = true;
        }

        try {
            $unit->inspect($provider);
        } catch (NoSuchMethodOnPluginClass $e) {
            $caught3 = true;
        }

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue($caught1);
        $this->assertTrue($caught2);
        $this->assertTrue($caught3);
    }

}