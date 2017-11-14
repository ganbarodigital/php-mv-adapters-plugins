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
 * @package   AdaptersAndPlugins\V1\Exceptions
 * @author    Stuart Herbert <stuherbert@ganbarodigital.com>
 * @copyright 2017-present Ganbaro Digital Ltd www.ganbarodigital.com
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link      http://ganbarodigital.github.io/php-mv-adapters-plugins
 */

namespace GanbaroDigitalTest\AdaptersAndPlugins\V1\Exceptions;

require_once(__DIR__ . "/../Fixtures/DummyPlugin.php");
require_once(__DIR__ . "/../Fixtures/Operations/DummyOperation.php");

use GanbaroDigital\AdaptersAndPlugins\V1\Exceptions\AdaptersAndPluginsException;
use GanbaroDigital\AdaptersAndPlugins\V1\Exceptions\NoSuchMethodOnPluginClass;
use GanbaroDigital\AdaptersAndPlugins\V1\Helpers;
use GanbaroDigital\AdaptersAndPlugins\V1\PluginTypes\PluginProvider;
use GanbaroDigital\ExceptionHelpers\V1\BaseExceptions\ParameterisedException;
use GanbaroDigital\MissingBits\TypeInspectors\GetPrintableType;
use GanbaroDigitalTest\AdaptersAndPlugins\V1\Fixtures\DummyPlugin;

/**
 * @coversDefaultClass GanbaroDigital\AdaptersAndPlugins\V1\Exceptions\NoSuchMethodOnPluginClass
 */
class NoSuchMethodOnPluginClassTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @coversNothing
     */
    public function test_can_instantiate()
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $unit = new NoSuchMethodOnPluginClass("");

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(NoSuchMethodOnPluginClass::class, $unit);
    }

    /**
     * @coversNothing
     */
    public function test_is_Exception()
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $unit = new NoSuchMethodOnPluginClass("");

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(\Exception::class, $unit);
    }

    /**
     * @coversNothing
     */
    public function test_is_AdaptersAndPluginsException()
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $unit = new NoSuchMethodOnPluginClass("");

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(AdaptersAndPluginsException::class, $unit);
    }

    /**
     * @coversNothing
     */
    public function test_is_ParameterisedException()
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $unit = new NoSuchMethodOnPluginClass("");

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(ParameterisedException::class, $unit);
    }

    /**
     * @coversNothing
     */
    public function test_is_RuntimeException()
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $unit = new NoSuchMethodOnPluginClass("");

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(\RuntimeException::class, $unit);
    }

    /**
     * @covers ::newFromInputParameter
     */
    public function test_can_create_from_input_parameter()
    {
        // ----------------------------------------------------------------
        // setup your test

        $plugin = new DummyPlugin;
        $this->assertInstanceOf(PluginProvider::class, $plugin);
        $className = Helpers\BuildTargetClassName::using($plugin, "Operations\\DummyOperation");
        $this->assertTrue(strlen($className) > 0);
        $this->assertTrue(class_exists($className));

        $expectedMessage = "ReflectionMethod->invokeArgs(): GanbaroDigitalTest\AdaptersAndPlugins\V1\Exceptions\NoSuchMethodOnPluginClassTest->test_can_create_from_input_parameter()@178 says plugin 'object<GanbaroDigitalTest\AdaptersAndPlugins\V1\Fixtures\DummyPlugin>' class 'GanbaroDigitalTest\AdaptersAndPlugins\V1\Fixtures\Operations\DummyOperation' does not provide method 'NoSuchMethod'";

        // ----------------------------------------------------------------
        // perform the change

        $unit = NoSuchMethodOnPluginClass::newFromInputParameter($className, 'className', [
            'pluginName' => GetPrintableType::of($plugin),
            'methodName' => 'NoSuchMethod',
        ]);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(NoSuchMethodOnPluginClass::class, $unit);

        $actualMessage = $unit->getMessage();
        $this->assertEquals($expectedMessage, $actualMessage);
    }

}