<?php

/*
 * This file is part of the Image Analyzer package.
 *
 * (c) Stephan Wentz <stephan@wentz.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Temp\ImageAnalyzer\Tests;

use Temp\ImageAnalyzer\ImageAnalyzer;
use Temp\ImageAnalyzer\ImageInfo;

/**
 * Image analyzer.
 *
 * @author Stephan Wentz <stephan@wentz.it>
 */
class ImageAnalyzerTest extends \PHPUnit_Framework_TestCase
{
    public function testSupports()
    {
        $driver = $this->prophesize('Temp\ImageAnalyzer\Driver\DriverInterface');
        $driver->supports('test')->willReturn(true);

        $analyzer = new ImageAnalyzer($driver->reveal());

        $result = $analyzer->supports('test');

        $this->assertTrue($result);
    }

    public function testAnalyze()
    {
        $info = new ImageInfo();

        $driver = $this->prophesize('Temp\ImageAnalyzer\Driver\DriverInterface');
        $driver->analyze('test')->willReturn($info);

        $analyzer = new ImageAnalyzer($driver->reveal());

        $result = $analyzer->analyze('test');

        $this->assertSame($info, $result);
    }
}
