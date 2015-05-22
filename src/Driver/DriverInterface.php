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
 * Image analyzer driver interface
 *
 * @author Stephan Wentz <stephan@wentz.it>
 */
interface DriverInterface
{
    /**
     * @param string $filename
     *
     * @return boolean
     */
    public function isAvailable($filename = null);

    /**
     * @param string $filename
     *
     * @return ImageInfo
     */
    public function analyze($filename);
}