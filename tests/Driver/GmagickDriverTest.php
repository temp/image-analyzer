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
 *
 * @requires extension gmagick
 */
class GmagickDriverTest extends \PHPUnit_Framework_TestCase
{
    public function testAvailable()
    {
        $driver = new GmagickDriver();

        if (!$driver->available()) {
            $this->markTestSkipped('gd extension not loaded.');
        }
    }

    /**
     * @param string $file
     * @param array  $expected
     *
     * @dataProvider imageProvider
     */
    public function testSupportsWithSupportedFiles($file, $expected)
    {
        $driver = new GmagickDriver();

        $this->assertTrue($driver->supports($file));
    }

    public function testSupportsWithUnsupportedFile()
    {
        $driver = new GmagickDriver();

        $this->assertFalse($driver->supports(__DIR__ . '/../fixture/file.unknown'));
    }

    /**
     * @expectedException \Temp\ImageAnalyzer\Exception\UnsupportedFileException
     */
    public function testAnalyzeThrowsExceptionOnUnsupportedFile()
    {
        $driver = new GmagickDriver();

        $driver->analyze(__DIR__ . '/../fixture/file.unknown');
    }

    /**
     * @param string $file
     * @param array  $expected
     *
     * @dataProvider imageProvider
     */
    public function testAnalyzeImageFiles($file, $expected)
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

    public function imageProvider()
    {
        return array(
            array(__DIR__ . '/../fixture/file.jpg', array(
                'analyzer'    => 'Temp\ImageAnalyzer\Driver\GmagickDriver',
                'colors'      => '69964',
                'colorspace'  => 'RGB',
                'compression' => null,
                'depth'       => '8',
                'format'      => 'JPEG',
                'height'      => '350',
                'profiles'    => array(),
                'quality'     => null,
                'ratioX'      => '1.3314285714285714',
                'ratioY'      => '0.75107296137339052',
                'resolutionX' => null,
                'resolutionY' => null,
                'type'        => 'TRUECOLOR',
                'units'       => 'undefined',
                'width'       => '466',
            )),
            array(__DIR__ . '/../fixture/file_cmyk.jpg', array(
                'analyzer'    => 'Temp\ImageAnalyzer\Driver\GmagickDriver',
                'colors'      => '39708',
                'colorspace'  => 'CMYK',
                'compression' => null,
                'depth'       => '8',
                'format'      => 'JPEG',
                'height'      => '350',
                'profiles'    => array(),
                'quality'     => null,
                'ratioX'      => '1.3314285714285714',
                'ratioY'      => '0.75107296137339052',
                'resolutionX' => '0.0',
                'resolutionY' => '0.0',
                'type'        => 'COLORSEPARATION',
                'units'       => 'undefined',
                'width'       => '466',
            )),
            array(__DIR__ . '/../fixture/file.gif', array(
                'analyzer'    => 'Temp\ImageAnalyzer\Driver\GmagickDriver',
                'colors'      => '255',
                'colorspace'  => 'RGB',
                'compression' => null,
                'depth'       => '8',
                'format'      => 'GIF',
                'height'      => '350',
                'profiles'    => array(),
                'quality'     => null,
                'ratioX'      => '1.3314285714285714',
                'ratioY'      => '0.75107296137339052',
                'resolutionX' => '0',
                'resolutionY' => '0',
                'type'        => 'PALETTE',
                'units'       => 'undefined',
                'width'       => '466',
            )),
            array(__DIR__ . '/../fixture/file.png', array(
                'analyzer'    => 'Temp\ImageAnalyzer\Driver\GmagickDriver',
                'colors'      => '69955',
                'colorspace'  => 'RGB',
                'compression' => null,
                'depth'       => '8',
                'format'      => 'PNG',
                'height'      => '350',
                'profiles'    => array(),
                'quality'     => null,
                'ratioX'      => '1.3314285714285714',
                'ratioY'      => '0.75107296137339052',
                'resolutionX' => '0.0',
                'resolutionY' => '0.0',
                'type'        => 'TRUECOLOR',
                'units'       => 'undefined',
                'width'       => '466',
            )),
        );
    }
}