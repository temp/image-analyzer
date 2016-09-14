<?php

/*
 * This file is part of the Image Analyzer package.
 *
 * (c) Stephan Wentz <stephan@wentz.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Temp\ImageAnalyzer;

use Temp\ImageAnalyzer\Driver\DriverInterface;

/**
 * Image analyzer.
 *
 * @author Stephan Wentz <stephan@wentz.it>
 */
class ImageAnalyzer
{
    /**
     * @var DriverInterface
     */
    private $driver;

    /**
     * @param DriverInterface $driver
     */
    public function __construct(DriverInterface $driver)
    {
        $this->driver = $driver;
    }

    /**
     * @param string $filename
     *
     * @return bool
     */
    public function supports($filename)
    {
        return $this->driver->supports($filename);
    }

    /**
     * @parm string $filename
     *
     * @return ImageInfo
     */
    public function analyze($filename)
    {
        return $this->driver->analyze($filename);
    }
}
