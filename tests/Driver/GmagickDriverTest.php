<?php

/*
 * This file is part of the Image Analyzer package.
 *
 * (c) Stephan Wentz <stephan@wentz.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Temp\ImageAnalyzer\Tests\Driver;

use Temp\ImageAnalyzer\Driver\GmagickDriver;

/**
 * Gmagick driver test
 *
 * @author Stephan Wentz <stephan@wentz.it>
 */
class GmagickDriverTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        if (!extension_loaded('gmagick')) {
            $this->markTestSkipped('gmagick extension is not installed');
        }
    }

    public function imageProvider()
    {
        return array(
            array(__DIR__ . '/../fixture/test.jpg', array(
                'analyzer'    => 'Temp\ImageAnalyzer\Driver\GmagickDriver',
                'colors'      => '69955',
                'colorspace'  => 'SRGB',
                'compression' => 'JPEG',
                'depth'       => '8',
                'format'      => 'JPEG',
                'height'      => '350',
                'profiles'    => array(),
                'quality'     => '86',
                'ratioX'      => '1.3314285714285714',
                'ratioY'      => '0.75107296137339052',
                'resolutionX' => '100.0',
                'resolutionY' => '100.0',
                'type'        => 'TRUECOLOR',
                'units'       => '0',
                'width'       => '466',
            )),
            array(__DIR__ . '/../fixture/test_cmyk.jpg', array(
                'analyzer'    => 'Temp\ImageAnalyzer\Driver\GmagickDriver',
                'colors'      => '114790',
                'colorspace'  => 'CMYK',
                'compression' => 'JPEG',
                'depth'       => '8',
                'format'      => 'JPEG',
                'height'      => '350',
                'profiles'    => array(),
                'quality'     => '91',
                'ratioX'      => '1.3314285714285714',
                'ratioY'      => '0.75107296137339052',
                'resolutionX' => '0.0',
                'resolutionY' => '0.0',
                'type'        => 'COLORSEPARATION',
                'units'       => '0',
                'width'       => '466',
            )),
            array(__DIR__ . '/../fixture/test.gif', array(
                'analyzer'    => 'Temp\ImageAnalyzer\Driver\GmagickDriver',
                'colors'      => '255',
                'colorspace'  => 'SRGB',
                'compression' => 'LZW',
                'depth'       => '8',
                'format'      => 'GIF',
                'height'      => '350',
                'profiles'    => array(),
                'quality'     => '0',
                'ratioX'      => '1.3314285714285714',
                'ratioY'      => '0.75107296137339052',
                'resolutionX' => '0',
                'resolutionY' => '0',
                'type'        => 'PALETTE',
                'units'       => '0',
                'width'       => '466',
            )),
            array(__DIR__ . '/../fixture/test.png', array(
                'analyzer'    => 'Temp\ImageAnalyzer\Driver\GmagickDriver',
                'colors'      => '69955',
                'colorspace'  => 'SRGB',
                'compression' => 'Zip',
                'depth'       => '8',
                'format'      => 'PNG',
                'height'      => '350',
                'profiles'    => array(),
                'quality'     => '0',
                'ratioX'      => '1.3314285714285714',
                'ratioY'      => '0.75107296137339052',
                'resolutionX' => '100.0',
                'resolutionY' => '100.0',
                'type'        => 'TRUECOLOR',
                'units'       => '0',
                'width'       => '466',
            )),
        );
    }

    /**
     * @param string $file
     * @param array  $expected
     *
     * @dataProvider imageProvider
     */
    public function testDriver($file, $expected)
    {
        $driver = new GmagickDriver();
        $imageInfo = $driver->analyze($file);

        $this->assertEquals($expected['analyzer'], $imageInfo->getAnalyzer());
        $this->assertEquals($expected['colors'], $imageInfo->getColors());
        $this->assertEquals($expected['colorspace'], $imageInfo->getColorspace());
        $this->assertEquals($expected['compression'], $imageInfo->getCompression());
        $this->assertEquals($expected['depth'], $imageInfo->getDepth());
        $this->assertEquals($expected['format'], $imageInfo->getFormat());
        $this->assertEquals($expected['height'], $imageInfo->getHeight());
        $this->assertEquals($expected['profiles'], $imageInfo->getProfiles());
        $this->assertEquals($expected['quality'], $imageInfo->getQuality());
        $this->assertEquals($expected['ratioX'], $imageInfo->getRatioX());
        $this->assertEquals($expected['ratioY'], $imageInfo->getRatioY());
        $this->assertEquals($expected['resolutionX'], $imageInfo->getResolutionX());
        $this->assertEquals($expected['resolutionY'], $imageInfo->getResolutionY());
        $this->assertEquals($expected['type'], $imageInfo->getType());
        $this->assertEquals($expected['units'], $imageInfo->getUnits());
        $this->assertEquals($expected['width'], $imageInfo->getWidth());
    }
}