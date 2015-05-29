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

use Temp\ImageAnalyzer\Exception\UnsupportedFileException;
use Temp\ImageAnalyzer\ImageInfo;

/**
 * GD image analyzer driver
 *
 * @author Stephan Wentz <stephan@wentz.it>
 */
class GdDriver implements DriverInterface
{
    /**
     * {@inheritdoc}
     */
    public function available()
    {
        return extension_loaded('gd');
    }

    /**
     * {@inheritdoc}
     */
    public function supports($filename)
    {
        return @getimagesize($filename) !== false;
    }

    /**
     * {@inheritdoc}
     */
    public function analyze($filename)
    {
        $imageSize = @getimagesize($filename);
        if ($imageSize === false) {
            throw new UnsupportedFileException("File type not supported.");
        }

        $imageInfo = new ImageInfo();

        $type = null;
        $colors = null;
        if ($imageSize[2] === IMAGETYPE_JPEG) {
            $gd = imagecreatefromjpeg($filename);
            $type = imageistruecolor($gd) ? 'TRUECOLOR' : 'PALETTE';
            $colors = imagecolorstotal($gd);
            imagedestroy($gd);
        } elseif ($imageSize[2] === IMAGETYPE_GIF) {
            $gd = imagecreatefromgif($filename);
            $type = imageistruecolor($gd) ? 'TRUECOLOR' : 'PALETTE';
            $colors = imagecolorstotal($gd);
            imagedestroy($gd);
        } elseif ($imageSize[2] === IMAGETYPE_PNG) {
            $gd = imagecreatefrompng($filename);
            $type = imageistruecolor($gd) ? 'TRUECOLOR' : 'PALETTE';
            $colors = imagecolorstotal($gd);
            imagedestroy($gd);
        }

        $imageInfo
            ->setAnalyzer(get_class($this))
            ->setSize($imageSize[0], $imageSize[1])
            ->setResolution(null, null)
            ->setUnits(null)
            ->setFormat($this->mapFormat($imageSize[2]))
            ->setColors($colors)
            ->setType($type)
            ->setColorspace(!empty($imageSize['channels']) ? ($imageSize['channels'] === 4 ? 'CMYK' : 'RGB') : 'RGB')
            ->setDepth($imageSize['bits'])
            ->setCompression(null)
            ->setQuality(null)
            ->setProfiles(null);

        return $imageInfo;
    }

    /**
     * @param string $type
     *
     * @return string
     */
    private function mapFormat($type)
    {
        $types = array(
            IMAGETYPE_BMP      => 'BMP',
            IMAGETYPE_COUNT    => 'COUNT',
            IMAGETYPE_GIF      => 'GIF',
            IMAGETYPE_ICO      => 'ICON',
            IMAGETYPE_IFF      => 'IFF',
            IMAGETYPE_JB2      => 'JB2',
            IMAGETYPE_JP2      => 'JP2',
            IMAGETYPE_JPC      => 'JPC',
            IMAGETYPE_JPEG     => 'JPEG',
            IMAGETYPE_JPEG2000 => 'JPEG2000',
            IMAGETYPE_JPX      => 'JPX',
            IMAGETYPE_PNG      => 'PNG',
            IMAGETYPE_PSD      => 'PSD',
            IMAGETYPE_SWC      => 'SWC',
            IMAGETYPE_SWF      => 'SWF',
            IMAGETYPE_TIFF_II  => 'TIFF_II',
            IMAGETYPE_TIFF_MM  => 'TIFF_MM',
            IMAGETYPE_WBMP     => 'WBMP',
            IMAGETYPE_XBM      => 'XBM',
            IMAGETYPE_UNKNOWN  => 'UNKNOWN',
        );

        if (!isset($types[$type])) {
            return $types[IMAGETYPE_UNKNOWN];
        }

        return $types[$type];
    }
}
