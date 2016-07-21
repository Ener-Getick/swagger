<?php

namespace gossi\swagger\tests;

use gossi\swagger\collections\Definitions;
use gossi\swagger\collections\Parameters;
use gossi\swagger\collections\Paths;
use gossi\swagger\collections\Responses;
use gossi\swagger\Operation;
use gossi\swagger\Parameter;
use gossi\swagger\Path;
use gossi\swagger\Response;
use gossi\swagger\Schema;
use gossi\swagger\Swagger;

class CollectionsTest extends \PHPUnit_Framework_TestCase
{
    public function testDefinitions()
    {
        $swagger = new Swagger();
        $definitions = $swagger->getDefinitions();

        $this->assertTrue($definitions instanceof Definitions);
        $this->assertEquals(0, $definitions->size());
        $this->assertFalse($definitions->has('User'));

        $user = new Schema();
        $definitions->set('User', $user);
        $this->assertEquals(1, $definitions->size());
        $this->assertTrue($definitions->has('User'));
        $this->assertTrue($definitions->get('User') instanceof Schema);
        $this->assertSame($user, $definitions->get('User'));

        $this->assertTrue(is_array($definitions->toArray()['User']));

        $definitions->remove('User');
        $this->assertEquals(0, $definitions->size());
        $this->assertFalse($definitions->has('User'));
    }

    public function testPaths()
    {
        $swagger = new Swagger();
        $paths = $swagger->getPaths();

        $this->assertTrue($paths instanceof Paths);
        $this->assertEquals(0, $paths->size());
        $this->assertFalse($paths->has('/pets'));

        $pets = new Path('/pets');
        $paths->add($pets);

        $this->assertEquals(1, $paths->size());
        $this->assertTrue($paths->has('/pets'));
        $this->assertTrue($paths->get('/pets') instanceof Path);
        $this->assertSame($pets, $paths->get('/pets'));
        $this->assertTrue($paths->contains($pets));

        $this->assertTrue(is_array($paths->toArray()['/pets']));

        $paths->remove('/pets');
        $this->assertEquals(0, $paths->size());
        $this->assertFalse($paths->has('/pets'));
    }

    public function testParameters()
    {
        $path = new Path('/pets');
        $parameters = $path->getOperation('get')->getParameters();

        $this->assertTrue($parameters instanceof Parameters);
        $this->assertEquals(0, $parameters->size());

        $id = new Parameter([
            'name' => 'id',
            'in' => 'path',
        ]);
        $parameters->add($id);
        $this->assertEquals(1, $parameters->size());
        $this->assertTrue($parameters->search('id', 'path'));
        $this->assertTrue($parameters->find('id', 'path') instanceof Parameter);
        $this->assertFalse($parameters->find('id', 'body') instanceof Parameter);

        $id2 = new Parameter([
            'name' => 'id',
            'in' => 'body',
        ]);
        $parameters->add($id2);
        $this->assertEquals(2, $parameters->size());
        $this->assertTrue($parameters->search('id', 'body'));
        $this->assertTrue($parameters->find('id', 'body') instanceof Parameter);
        $this->assertSame($id, $parameters->find('id', 'path'));
        $this->assertSame($id2, $parameters->find('id', 'body'));

        $parameter = $parameters->get('bar', 'query');
        $this->assertEquals('bar', $parameter->getName());
        $this->assertEquals('query', $parameter->getIn());

        $this->assertTrue(is_array($parameters->toArray()[0]));
        $this->assertTrue(is_array($parameters->toArray()[1]));

        $parameters->remove($id);
        $parameters->remove($id2);
        $parameters->remove($parameter);
        $this->assertEquals(0, $parameters->size());

        // test $ref
        $parameters->setRef('#/definitions/id');
        $this->assertEquals(['$ref' => '#/definitions/id'], $parameters->toArray());
    }

    public function testResponses()
    {
        $operation = new Operation();
        $responses = $operation->getResponses();

        $this->assertTrue($responses instanceof Responses);
        $this->assertEquals(0, $responses->size());
        $this->assertFalse($responses->has('200'));

        $ok = new Response('200');
        $responses->add($ok);
        $this->assertEquals(1, $responses->size());
        $this->assertTrue($responses->has('200'));
        $this->assertTrue($responses->get('200') instanceof Response);
        $this->assertSame($ok, $responses->get('200'));
        $this->assertTrue($responses->contains($ok));

        $this->assertTrue(is_array($responses->toArray()['200']));

        $responses->remove('200');
        $this->assertEquals(0, $responses->size());
        $this->assertFalse($responses->has('200'));
    }
}
