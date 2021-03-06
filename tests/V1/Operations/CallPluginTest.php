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

namespace GanbaroDigitalTest\AdaptersAndPlugins\V1\Operations;

require_once(__DIR__ . "/../Fixtures/DummyPlugin.php");
require_once(__DIR__ . "/../Fixtures/NotAPlugin.php");

use GanbaroDigital\AdaptersAndPlugins\V1\Operations\CallPlugin;
use GanbaroDigitalTest\AdaptersAndPlugins\V1\Fixtures\DummyPlugin;
use GanbaroDigitalTest\AdaptersAndPlugins\V1\Fixtures\NotAPlugin;

/**
 * @coversDefaultClass GanbaroDigital\AdaptersAndPlugins\V1\Operations\CallPlugin
 */
class CallPluginTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @covers ::using
     */
    public function test_can_call_a_plugin()
    {
        // ----------------------------------------------------------------
        // setup your test

        $provider = new DummyPlugin;
        $plugin = "Operations\\DummyOperation";
        $method = "reflectBack";

        $expectedResult = [
            "this is a test",
            "no really it is"
        ];

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = CallPlugin::using($provider, $plugin, $method, "this is a test", "no really it is");

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @covers ::using
     */
    public function test_can_call_plugin_with_no_parameters()
    {
        // ----------------------------------------------------------------
        // setup your test

        $provider = new DummyPlugin;
        $plugin = "Operations\\DummyOperation";
        $method = "reflectBack";

        // we expect an empty array because our target plugin just sends
        // back whatever we send it
        $expectedResult = [];

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = CallPlugin::using($provider, $plugin, $method);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @covers ::using
     * @expectedException GanbaroDigital\AdaptersAndPlugins\V1\Exceptions\NoSuchPluginClass
     */
    public function test_throws_NoSuchPluginClass_if_plugin_does_not_exist()
    {
        // ----------------------------------------------------------------
        // setup your test

        $provider = new DummyPlugin;
        $plugin = "DoesNotExist";
        $method = "NeitherDoesThis";

        // ----------------------------------------------------------------
        // perform the change

        CallPlugin::using($provider, $plugin, $method);

        // ----------------------------------------------------------------
        // test the results
    }

    /**
     * @covers ::using
     * @expectedException GanbaroDigital\AdaptersAndPlugins\V1\Exceptions\NotAPluginClass
     */
    public function test_throws_NotAPluginClass_if_plugin_does_not_implement_PluginClass()
    {
        // ----------------------------------------------------------------
        // setup your test

        $provider = new DummyPlugin;
        $plugin = "Operations\\NotAnOperation";
        $method = "NeitherDoesThis";

        // ----------------------------------------------------------------
        // perform the change

        CallPlugin::using($provider, $plugin, $method);

        // ----------------------------------------------------------------
        // test the results
    }

    /**
     * @covers ::using
     * @expectedException GanbaroDigital\AdaptersAndPlugins\V1\Exceptions\NoSuchMethodOnPluginClass
     */
    public function test_throws_NoSuchMethodOnPluginClass_if_plugin_does_not_implement_targeted_method()
    {
        // ----------------------------------------------------------------
        // setup your test

        $provider = new DummyPlugin;
        $plugin = "Operations\\DummyOperation";
        $method = "thisMethodDoesNotExist";

        // ----------------------------------------------------------------
        // perform the change

        CallPlugin::using($provider, $plugin, $method);

        // ----------------------------------------------------------------
        // test the results
    }

}