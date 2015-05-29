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

use Imagick;
use Temp\ImageAnalyzer\Exception\UnsupportedFileException;
use Temp\ImageAnalyzer\ImageInfo;

/**
 * Imagick extension image analyzer driver
 *
 * @author Stephan Wentz <stephan@wentz.it>
 */
class ImagickDriver implements DriverInterface
{
    /**
     * {@inheritdoc}
     */
    public function available()
    {
        return extension_loaded('imagick');
    }

    /**
     * {@inheritdoc}
     */
    public function supports($filename)
    {
        try {
            new Imagick($filename);
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
        try {
            $imagick = new Imagick($filename);
        } catch (\Exception $e) {
            throw new UnsupportedFileException("File type not supported.", 0, $e);
        }

        $imageInfo = new ImageInfo();

        $identify = $imagick->identifyImage(false);

        $imageInfo
            ->setAnalyzer(get_class($this))
            ->setSize($imagick->getImageWidth(), $imagick->getImageHeight())
            ->setResolution($imagick->getImageResolution()['x'], $imagick->getImageResolution()['y'])
            ->setUnits($this->mapUnits($imagick->getImageUnits()))
            ->setFormat($imagick->getImageFormat())
            ->setColors($imagick->getImageColors())
            ->setType($this->mapType($imagick->getImageType()))
            ->setColorspace($this->mapColorspace($imagick->getImageColorspace()))
            ->setDepth($imagick->getImageDepth())
            ->setCompression($identify['compression'])
            ->setQuality($imagick->getImageCompressionQuality())
            ->setProfiles($imagick->getImageProfiles('*', false));

        return $imageInfo;
    }

    /**
     * @param int $units
     *
     * @return string
     */
    private function mapUnits($units)
    {
        $imagickUnits = array(
            Imagick::RESOLUTION_PIXELSPERCENTIMETER => 'PixelsPerCentimeter',
            Imagick::RESOLUTION_PIXELSPERINCH => 'PixelsPerInch',
            Imagick::RESOLUTION_UNDEFINED => 'undefined',
        );

        if (!isset($imagickUnits[$units])) {
            return $imagickUnits[Imagick::RESOLUTION_UNDEFINED];
        }

        return $imagickUnits[$units];
    }

    /**
     * @param int $type
     *
     * @return string
     */
    private function mapType($type)
    {
        $types = array(
            Imagick::IMGTYPE_BILEVEL => 'BILEVEL',
            Imagick::IMGTYPE_GRAYSCALE => 'GRAYSCALE',
            Imagick::IMGTYPE_GRAYSCALEMATTE => 'GRAYSCALEMATTE',
            Imagick::IMGTYPE_PALETTE => 'PALETTE',
            Imagick::IMGTYPE_PALETTEMATTE => 'PALETTEMATTE',
            Imagick::IMGTYPE_TRUECOLOR => 'TRUECOLOR',
            Imagick::IMGTYPE_TRUECOLORMATTE => 'TRUECOLORMATTE',
            Imagick::IMGTYPE_COLORSEPARATION => 'COLORSEPARATION',
            Imagick::IMGTYPE_COLORSEPARATIONMATTE => 'COLORSEPARATIONMATTE',
            Imagick::IMGTYPE_OPTIMIZE => 'OPTIMIZE',
            Imagick::IMGTYPE_UNDEFINED => 'UNDEFINED',
        );

        if (!isset($types[$type])) {
            return $types[Imagick::IMGTYPE_UNDEFINED];
        }

        return $types[$type];
    }

    /**
     * @param integer $colorspace
     *
     * @return null|string
     */
    private function mapColorspace($colorspace)
    {
        $colorspaces = array(
            Imagick::COLORSPACE_CMY => 'CMY',
            Imagick::COLORSPACE_CMYK => 'CMYK',
            Imagick::COLORSPACE_GRAY => 'GRAY',
            Imagick::COLORSPACE_HSB => 'HSB',
            Imagick::COLORSPACE_HSL => 'HSL',
            Imagick::COLORSPACE_HWB => 'HWB',
            Imagick::COLORSPACE_LAB => 'LAB',
            Imagick::COLORSPACE_LOG => 'LOG',
            Imagick::COLORSPACE_OHTA => 'OHTA',
            Imagick::COLORSPACE_REC601LUMA => 'REC601LUMA',
            Imagick::COLORSPACE_RGB => 'RGB',
            Imagick::COLORSPACE_REC709LUMA => 'REC709LUMA',
            Imagick::COLORSPACE_SRGB => 'SRGB',
            Imagick::COLORSPACE_TRANSPARENT => 'TRANSPARENT',
            Imagick::COLORSPACE_XYZ => 'XYZ',
            Imagick::COLORSPACE_YCBCR => 'YCBCR',
            Imagick::COLORSPACE_YCC => 'YCC',
            Imagick::COLORSPACE_YIQ => 'YIQ',
            Imagick::COLORSPACE_YPBPR => 'YPBPR',
            Imagick::COLORSPACE_YUV => 'YUV',
            Imagick::COLORSPACE_UNDEFINED =>  'UNDEFINED',
        );

        if (!isset($colorspaces[$colorspace])) {
            return $colorspaces[Imagick::COLORSPACE_UNDEFINED];
        }

        return $colorspaces[$colorspace];
    }
}
