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

use Temp\ImageAnalyzer\ImageInfo;

/**
 * Imagick extension image analyzer driver
 *
 * @author Stephan Wentz <stephan@wentz.it>
 */
class GmagickDriver implements DriverInterface
{
    /**
     * {@inheritdoc}
     */
    public function isAvailable($filename = null)
    {
        return extension_loaded('gmagick');
    }

    /**
     * {@inheritdoc}
     */
    public function analyze($filename)
    {
        $gmagick = new \Gmagick($filename);
        $imageInfo = new ImageInfo();

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
            ->setQuality(null)
            ->setProfiles($gmagick->getImageProfiles('*', false));

        return $imageInfo;
    }

    /**
     * @param int $units
     *
     * @return null|string
     */
    private function mapUnits($units)
    {
        switch ($units) {
            case \Gmagick::RESOLUTION_PIXELSPERCENTIMETER:
                return 'PixelsPerCentimeter';
            case \Gmagick::RESOLUTION_PIXELSPERINCH:
                return 'PixelsPerInch';
            case \Gmagick::RESOLUTION_UNDEFINED:
                return null;
        }
    }

    /**
     * @param string $type
     *
     * @return string
     */
    private function mapType($type)
    {
        switch ($type) {
            case \Imagick::IMGTYPE_BILEVEL:
                return 'BILEVEL';
            case \Imagick::IMGTYPE_GRAYSCALE:
                return 'GRAYSCALE';
            case \Imagick::IMGTYPE_GRAYSCALEMATTE:
                return 'GRAYSCALEMATTE';
            case \Imagick::IMGTYPE_PALETTE:
                return 'PALETTE';
            case \Imagick::IMGTYPE_PALETTEMATTE:
                return 'PALETTEMATTE';
            case \Imagick::IMGTYPE_TRUECOLOR:
                return 'TRUECOLOR';
            case \Imagick::IMGTYPE_TRUECOLORMATTE:
                return 'TRUECOLORMATTE';
            case \Imagick::IMGTYPE_COLORSEPARATION:
                return 'COLORSEPARATION';
            case \Imagick::IMGTYPE_COLORSEPARATIONMATTE:
                return 'COLORSEPARATIONMATTE';
            case \Imagick::IMGTYPE_OPTIMIZE:
                return 'OPTIMIZE';
            case \Imagick::IMGTYPE_UNDEFINED:
            default:
                return 'UNDEFINED';
        }
    }

    /**
     * @param integer $colorspace
     *
     * @return string
     */
    private function mapColorspace($colorspace)
    {
        switch ($colorspace) {
            case \Gmagick::COLORSPACE_CMY:
                return 'CMY';
            case \Gmagick::COLORSPACE_CMYK:
                return 'CMYK';
            case \Gmagick::COLORSPACE_GRAY:
                return 'GRAY';
            case \Gmagick::COLORSPACE_HSB:
                return 'HSB';
            case \Gmagick::COLORSPACE_HSL:
                return 'HSL';
            case \Gmagick::COLORSPACE_HWB:
                return 'HWB';
            case \Gmagick::COLORSPACE_LAB:
                return 'LAB';
            case \Gmagick::COLORSPACE_LOG:
                return 'LOG';
            case \Gmagick::COLORSPACE_OHTA:
                return 'OHTA';
            case \Gmagick::COLORSPACE_REC601LUMA:
                return 'REC601LUMA';
            case \Gmagick::COLORSPACE_RGB:
                return 'RGB';
            case \Gmagick::COLORSPACE_REC709LUMA:
                return 'REC709LUMA';
            case \Gmagick::COLORSPACE_SRGB:
                return 'SRGB';
            case \Gmagick::COLORSPACE_TRANSPARENT:
                return 'TRANSPARENT';
            case \Gmagick::COLORSPACE_XYZ:
                return 'XYZ';
            case \Gmagick::COLORSPACE_YCBCR:
                return 'YCBCR';
            case \Gmagick::COLORSPACE_YCC:
                return 'YCC';
            case \Gmagick::COLORSPACE_YIQ:
                return 'YIQ';
            case \Gmagick::COLORSPACE_YPBPR:
                return 'YPBPR';
            case \Gmagick::COLORSPACE_YUV:
                return 'YUV';
            case \Gmagick::COLORSPACE_UNDEFINED:
            default:
                return 'UNDEFINED';
        }
    }
}