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

use Temp\ImageAnalyzer\ImageInfo;

/**
 * Image info test
 *
 * @author Stephan Wentz <stephan@wentz.it>
 */
class ImageInfoTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $info = new ImageInfo();

        $this->assertNull($info->getColors());
    }
}