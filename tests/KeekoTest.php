<?php

/*
 * This file is part of the Swagger package.
 *
 * (c) EXSyst
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EXSyst\Component\Swagger\tests;

use EXSyst\Component\Swagger\Swagger;
use PHPUnit\Framework\TestCase;

class KeekoTest extends TestCase
{
    private function fileToArray($filename)
    {
        return json_decode(file_get_contents($filename), true);
    }

    public function testUser()
    {
        $filename = __DIR__.'/fixtures/keeko-user.json';
        $swagger = Swagger::fromFile($filename);

        $this->assertEquals($this->fileToArray($filename), $swagger->toArray());
    }
}
