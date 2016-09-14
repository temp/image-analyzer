<?php

/*
 * This file is part of the Image Analyzer package.
 *
 * (c) Stephan Wentz <stephan@wentz.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Temp\ImageAnalyzer\Driver;

use Gmagick;
use Temp\ImageAnalyzer\Exception\UnsupportedFileException;
use Temp\ImageAnalyzer\ImageInfo;

/**
 * Imagick extension image analyzer driver.
 *
 * @author Stephan Wentz <stephan@wentz.it>
 */
class GmagickDriver implements DriverInterface
{
    /**
     * {@inheritdoc}
     */
    public function available()
    {
        return extension_loaded('gmagick');
    }

    /**
     * {@inheritdoc}
     */
    public function supports($filename)
    {
        try {
            new Gmagick($filename);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function analyze($filename)
    {
        $imageInfo = new ImageInfo();

        try {
            $gmagick = new Gmagick($filename);
        } catch (\Exception $e) {
            throw new UnsupportedFileException('File type not supported.', 0, $e);
        }

        $imageInfo
            ->setAnalyzer(get_class($this))
            ->setSize($gmagick->getImageWidth(), $gmagick->getImageHeight())
            ->setResolution($gmagick->getImageResolution()['x'], $gmagick->getImageResolution()['y'])
            ->setUnits($this->mapUnits($gmagick->getImageUnits()))
            ->setFormat($gmagick->getImageFormat())
            ->setColors($gmagick->getImageColors())
            ->setType($this->mapType($gmagick->getImageType()))
            ->setColorspace($this->mapColorspace($gmagick->getImageColorspace()))
            ->setDepth($gmagick->getImageDepth())
            ->setCompression(null)
            ->setQuality(null);

        return $imageInfo;
    }

    /**
     * @param int $units
     *
     * @return string
     */
    private function mapUnits($units)
    {
        $gmagickUnits = [
            Gmagick::RESOLUTION_PIXELSPERCENTIMETER => 'PixelsPerCentimeter',
            Gmagick::RESOLUTION_PIXELSPERINCH       => 'PixelsPerInch',
            Gmagick::RESOLUTION_UNDEFINED           => 'undefined',
        ];

        if (!isset($gmagickUnits[$units])) {
            return $gmagickUnits[Gmagick::RESOLUTION_UNDEFINED];
        }

        return $gmagickUnits[$units];
    }

    /**
     * @param string $type
     *
     * @return string
     */
    private function mapType($type)
    {
        $types = [
            Gmagick::IMGTYPE_BILEVEL              => 'BILEVEL',
            Gmagick::IMGTYPE_GRAYSCALE            => 'GRAYSCALE',
            Gmagick::IMGTYPE_GRAYSCALEMATTE       => 'GRAYSCALEMATTE',
            Gmagick::IMGTYPE_PALETTE              => 'PALETTE',
            Gmagick::IMGTYPE_PALETTEMATTE         => 'PALETTEMATTE',
            Gmagick::IMGTYPE_TRUECOLOR            => 'TRUECOLOR',
            Gmagick::IMGTYPE_TRUECOLORMATTE       => 'TRUECOLORMATTE',
            Gmagick::IMGTYPE_COLORSEPARATION      => 'COLORSEPARATION',
            Gmagick::IMGTYPE_COLORSEPARATIONMATTE => 'COLORSEPARATIONMATTE',
            Gmagick::IMGTYPE_OPTIMIZE             => 'OPTIMIZE',
            Gmagick::IMGTYPE_UNDEFINED            => 'UNDEFINED',
        ];

        if (!isset($types[$type])) {
            return $types[Gmagick::IMGTYPE_UNDEFINED];
        }

        return $types[$type];
    }

    /**
     * @param int $colorspace
     *
     * @return string
     */
    private function mapColorspace($colorspace)
    {
        $colorspaces = [
            Gmagick::COLORSPACE_CMYK => 'CMYK',
            Gmagick::COLORSPACE_GRAY => 'GRAY',
            Gmagick::COLORSPACE_HSL  => 'HSL',
            Gmagick::COLORSPACE_HWB  => 'HWB',
            Gmagick::COLORSPACE_LAB  => 'LAB',
            Gmagick::COLORSPACE_OHTA => 'OHTA',
            Gmagick::COLORSPACE_RGB  => 'RGB',
            //Gmagick::COLORSPACE_REC709LUMA => 'REC709LUMA',
            Gmagick::COLORSPACE_SRGB        => 'SRGB',
            Gmagick::COLORSPACE_TRANSPARENT => 'TRANSPARENT',
            Gmagick::COLORSPACE_XYZ         => 'XYZ',
            Gmagick::COLORSPACE_YCBCR       => 'YCBCR',
            Gmagick::COLORSPACE_YCC         => 'YCC',
            Gmagick::COLORSPACE_YIQ         => 'YIQ',
            Gmagick::COLORSPACE_YPBPR       => 'YPBPR',
            Gmagick::COLORSPACE_YUV         => 'YUV',
            Gmagick::COLORSPACE_UNDEFINED   => 'UNDEFINED',
        ];


        if (!isset($colorspaces[$colorspace])) {
            return $colorspaces[Gmagick::COLORSPACE_UNDEFINED];
        }

        return $colorspaces[$colorspace];
    }
}
