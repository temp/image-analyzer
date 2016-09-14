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

use Temp\ImageAnalyzer\Driver\GdDriver;

/**
 * GD driver test.
 *
 * @author Stephan Wentz <stephan@wentz.it>
 *
 * @requires extension gd
 */
class GdDriverTest extends \PHPUnit_Framework_TestCase
{
    public function testAvailable()
    {
        $driver = new GdDriver();

        $this->assertTrue($driver->available());
    }

    /**
     * @param string $file
     * @param array  $expected
     *
     * @dataProvider imageProvider
     */
    public function testSupportsWithSupportedFiles($file, $expected)
    {
        $driver = new GdDriver();

        $this->assertTrue($driver->supports($file));
    }

    public function testSupportsWithUnsupportedFile()
    {
        $driver = new GdDriver();

        $this->assertFalse($driver->supports(__DIR__.'/../fixture/file.unknown'));
    }

    /**
     * @expectedException \Temp\ImageAnalyzer\Exception\UnsupportedFileException
     */
    public function testAnalyzeThrowsExceptionOnUnsupportedFile()
    {
        $driver = new GdDriver();

        $driver->analyze(__DIR__.'/../fixture/file.unknown');
    }

    /**
     * @param string $file
     * @param array  $expected
     *
     * @dataProvider imageProvider
     */
    public function testAnalyzeImageFiles($file, $expected)
    {
        $driver = new GdDriver();
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
        return [
            [__DIR__.'/../fixture/file.jpg', [
                'analyzer'    => 'Temp\ImageAnalyzer\Driver\GdDriver',
                'colors'      => '0',
                'colorspace'  => 'RGB',
                'compression' => null,
                'depth'       => '8',
                'format'      => 'JPEG',
                'height'      => '350',
                'profiles'    => null,
                'quality'     => null,
                'ratioX'      => '1.3314285714285714',
                'ratioY'      => '0.75107296137339052',
                'resolutionX' => null,
                'resolutionY' => null,
                'type'        => 'TRUECOLOR',
                'units'       => null,
                'width'       => '466',
            ]],
            [__DIR__.'/../fixture/file_cmyk.jpg', [
                'analyzer'    => 'Temp\ImageAnalyzer\Driver\GdDriver',
                'colors'      => '0',
                'colorspace'  => 'CMYK',
                'compression' => null,
                'depth'       => '8',
                'format'      => 'JPEG',
                'height'      => '350',
                'profiles'    => null,
                'quality'     => null,
                'ratioX'      => '1.3314285714285714',
                'ratioY'      => '0.75107296137339052',
                'resolutionX' => null,
                'resolutionY' => null,
                'type'        => 'TRUECOLOR',
                'units'       => null,
                'width'       => '466',
            ]],
            [__DIR__.'/../fixture/file.gif', [
                'analyzer'    => 'Temp\ImageAnalyzer\Driver\GdDriver',
                'colors'      => '256',
                'colorspace'  => 'RGB',
                'compression' => null,
                'depth'       => '8',
                'format'      => 'GIF',
                'height'      => '350',
                'profiles'    => null,
                'quality'     => null,
                'ratioX'      => '1.3314285714285714',
                'ratioY'      => '0.75107296137339052',
                'resolutionX' => null,
                'resolutionY' => null,
                'type'        => 'PALETTE',
                'units'       => null,
                'width'       => '466',
            ]],
            [__DIR__.'/../fixture/file.png', [
                'analyzer'    => 'Temp\ImageAnalyzer\Driver\GdDriver',
                'colors'      => '0',
                'colorspace'  => 'RGB',
                'compression' => null,
                'depth'       => '8',
                'format'      => 'PNG',
                'height'      => '350',
                'profiles'    => null,
                'quality'     => null,
                'ratioX'      => '1.3314285714285714',
                'ratioY'      => '0.75107296137339052',
                'resolutionX' => null,
                'resolutionY' => null,
                'type'        => 'TRUECOLOR',
                'units'       => null,
                'width'       => '466',
            ]],
        ];
    }
}
