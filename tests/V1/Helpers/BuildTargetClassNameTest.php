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
 * @package   AdaptersAndPlugins\V1\Helpers
 * @author    Stuart Herbert <stuherbert@ganbarodigital.com>
 * @copyright 2017-present Ganbaro Digital Ltd www.ganbarodigital.com
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link      http://ganbarodigital.github.io/php-mv-adapters-plugins
 */

namespace GanbaroDigitalTest\AdaptersAndPlugins\V1\Helpers;

require_once(__DIR__ . "/../Fixtures/DummyPlugin.php");

use GanbaroDigital\AdaptersAndPlugins\V1\Helpers\BuildTargetClassName;
use GanbaroDigitalTest\AdaptersAndPlugins\V1\Fixtures\DummyPlugin;

/**
 * @coversDefaultClass GanbaroDigital\AdaptersAndPlugins\V1\Helpers\BuildTargetClassName
 */
class BuildTargetClassNameTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @covers ::using
     */
    public function test_returns_a_possible_class_name()
    {
        // ----------------------------------------------------------------
        // setup your test

        $provider = new DummyPlugin;
        $plugin = 'Operations\DummyOperation';
        $expectedResult = 'GanbaroDigitalTest\\AdaptersAndPlugins\\V1\\Fixtures\\' . $plugin;

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = BuildTargetClassName::using($provider, $plugin);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @covers ::using
     */
    public function test_does_not_check_if_class_name_exists()
    {
        // ----------------------------------------------------------------
        // setup your test

        $provider = new DummyPlugin;
        $plugin = 'DoesNotExist\NeverEver';
        $expectedResult = 'GanbaroDigitalTest\\AdaptersAndPlugins\\V1\\Fixtures\\' . $plugin;

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = BuildTargetClassName::using($provider, $plugin);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

}