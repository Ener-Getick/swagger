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

use EXSyst\Component\Swagger\Collections\Definitions;
use EXSyst\Component\Swagger\Collections\Parameters;
use EXSyst\Component\Swagger\Collections\Paths;
use EXSyst\Component\Swagger\Collections\Responses;
use EXSyst\Component\Swagger\Operation;
use EXSyst\Component\Swagger\Parameter;
use EXSyst\Component\Swagger\Path;
use EXSyst\Component\Swagger\Response;
use EXSyst\Component\Swagger\Schema;
use EXSyst\Component\Swagger\Swagger;
use PHPUnit\Framework\TestCase;

class CollectionsTest extends TestCase
{
    public function testDefinitions()
    {
        $swagger = new Swagger();
        $definitions = $swagger->getDefinitions();

        $this->assertInstanceOf(Definitions::class, $definitions);
        $this->assertNull($definitions->toArray());
        $this->assertFalse($definitions->has('User'));

        $user = new Schema();
        $definitions->set('User', $user);
        $this->assertCount(1, $definitions->toArray());
        $this->assertTrue($definitions->has('User'));
        $this->assertSame($user, $definitions->get('User'));

        $this->assertInternalType('array', $definitions->toArray()['User']);

        $definitions->remove('User');
        $this->assertNull($definitions->toArray());
        $this->assertFalse($definitions->has('User'));
    }

    public function testPaths()
    {
        $swagger = new Swagger();
        $paths = $swagger->getPaths();

        $this->assertInstanceOf(Paths::class, $paths);
        $this->assertNull($paths->toArray());
        $this->assertFalse($paths->has('/pets'));

        $pets = new Path();
        $paths->set('/pets', $pets);

        $this->assertCount(1, $paths->toArray());
        $this->assertTrue($paths->has('/pets'));
        $this->assertSame($pets, $paths->get('/pets'));

        $this->assertInternalType('array', $paths->toArray()['/pets']);

        $paths->remove('/pets');
        $this->assertNull($paths->toArray());
        $this->assertFalse($paths->has('/pets'));
    }

    public function testParameters()
    {
        $path = new Path();
        $parameters = $path->getOperation('get')->getParameters();

        $this->assertInstanceOf(Parameters::class, $parameters);
        $this->assertNull($parameters->toArray());

        $id = new Parameter([
            'name' => 'id',
            'in' => 'path',
        ]);
        $parameters->add($id);
        $this->assertCount(1, $parameters->toArray());
        $this->assertTrue($parameters->has('id', 'path'));

        $id2 = new Parameter([
            'name' => 'id',
            'in' => 'body',
        ]);
        $parameters->add($id2);
        $this->assertCount(2, $parameters->toArray());
        $this->assertTrue($parameters->has('id', 'body'));
        $this->assertSame($id, $parameters->get('id', 'path'));
        $this->assertSame($id2, $parameters->get('id', 'body'));

        $parameter = $parameters->get('bar', 'query');
        $this->assertEquals('bar', $parameter->getName());
        $this->assertEquals('query', $parameter->getIn());

        $this->assertInternalType('array', $parameters->toArray()[0]);
        $this->assertInternalType('array', $parameters->toArray()[1]);

        $parameters->remove($id);
        $parameters->remove($id2);
        $parameters->remove($parameter);
        $this->assertNull($parameters->toArray());

        // test $ref
        $parameters->setRef('#/definitions/id');
        $this->assertEquals(['$ref' => '#/definitions/id'], $parameters->toArray());
    }

    public function testResponses()
    {
        $operation = new Operation();
        $responses = $operation->getResponses();

        $this->assertInstanceOf(Responses::class, $responses);
        $this->assertCount(0, $responses->toArray());
        $this->assertFalse($responses->has('200'));

        $ok = new Response();
        $responses->set('200', $ok);
        $this->assertCount(1, $responses->toArray());
        $this->assertTrue($responses->has('200'));
        $this->assertInstanceOf(Response::class, $responses->get('200'));
        $this->assertSame($ok, $responses->get('200'));

        $this->assertInternalType('array', $responses->toArray()['200']);

        $responses->remove('200');
        $this->assertCount(0, $responses->toArray());
        $this->assertFalse($responses->has('200'));
    }
}
