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
 * @package   AdaptersAndPlugins\V1\Checks
 * @author    Stuart Herbert <stuherbert@ganbarodigital.com>
 * @copyright 2017-present Ganbaro Digital Ltd www.ganbarodigital.com
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link      http://ganbarodigital.github.io/php-mv-adapters-plugins
 */

namespace GanbaroDigitalTest\AdaptersAndPlugins\V1\Checks;

require_once(__DIR__ . "/../Fixtures/DummyPlugin.php");

use GanbaroDigital\AdaptersAndPlugins\V1\Checks\IsPluginClass;
use GanbaroDigital\MissingBits\Checks\Check;
use GanbaroDigitalTest\AdaptersAndPlugins\V1\Fixtures\Operations\DummyOperation;

/**
 * @coversDefaultClass GanbaroDigital\AdaptersAndPlugins\V1\Checks\IsPluginClass
 */
class IsPluginClassTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @covers ::using
     */
    public function test_is_Check()
    {
        // ----------------------------------------------------------------
        // setup your test


        // ----------------------------------------------------------------
        // perform the change

        $unit1 = new IsPluginClass;
        $unit2 = IsPluginClass::using();

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(Check::class, $unit1);
        $this->assertInstanceOf(Check::class, $unit2);
    }

    /**
     * @covers ::check
     * @covers ::inspect
     * @covers ::__invoke
     */
    public function test_returns_TRUE_for_PluginClass_name()
    {
        // ----------------------------------------------------------------
        // setup your test

        $targetClass = DummyOperation::class;
        $unit = new IsPluginClass;

        // ----------------------------------------------------------------
        // perform the change
        //
        // we check all the different public methods here

        $actualResult1 = IsPluginClass::check($targetClass);
        $actualResult2 = $unit($targetClass);
        $actualResult3 = $unit->inspect($targetClass);

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue($actualResult1);
        $this->assertTrue($actualResult2);
        $this->assertTrue($actualResult3);
    }

    /**
     * @covers ::check
     * @covers ::inspect
     * @covers ::__invoke
     * @dataProvider provideNonPluginClasses
     */
    public function test_returns_FALSE_for_everything_else($item)
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new IsPluginClass;

        // ----------------------------------------------------------------
        // perform the change
        //
        // we check all the different public methods here

        $actualResult1 = IsPluginClass::check($item);
        $actualResult2 = $unit($item);
        $actualResult3 = $unit->inspect($item);

        // ----------------------------------------------------------------
        // test the results

        $this->assertFalse($actualResult1);
        $this->assertFalse($actualResult2);
        $this->assertFalse($actualResult3);
    }

    public function provideNonPluginClasses()
    {
        return [
            'null' => [ null ],
            'array' => [ [ 1,2,3,4 ] ],
            'bool(true)' => [ true ],
            'bool(false)' => [ false ],
            'callable(function)' => [ function() { } ],
            'callable(string)' => [ 'sprintf' ],
            'double(negative)' => [ -3.1415927 ],
            'double(zero)' => [ 0.0 ],
            'double(positive)' => [ 3.1415927 ],
            'integer(negative)' => [ -100 ],
            'integer(zero)' => [ 0 ],
            'integer(positive)' => [ 100 ],
            'object' => [ new \stdClass ],
            'resource' => [ STDIN ],
            'string' => [ 'PluginProvider' ]
        ];
    }

}