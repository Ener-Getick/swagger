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

class SwaggerTest extends TestCase
{
    public function testVersion()
    {
        $swagger = new Swagger();
        $this->assertEquals('2.0', $swagger->getVersion());
    }

    public function testBasics()
    {
        $swagger = new Swagger();
        $swagger->setBasePath('/api');
        $swagger->setHost('http://example.com');

        $this->assertEquals('/api', $swagger->getBasePath());
        $this->assertEquals('http://example.com', $swagger->getHost());

        $this->assertEquals([
            'swagger' => '2.0',
            'host' => 'http://example.com',
            'basePath' => '/api',
        ], $swagger->toArray());
    }
}
