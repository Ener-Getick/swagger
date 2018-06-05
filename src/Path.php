<?php

/*
 * This file is part of the Swagger package.
 *
 * (c) EXSyst
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EXSyst\OAS;

use EXSyst\OAS\Collections\Parameters;

final class Path extends AbstractObject
{
    use ExtensionPart;

    private static $methods = ['get', 'put', 'post', 'delete', 'options', 'head', 'patch', 'trace'];

    /** @var string|null */
    private $ref;

    /** @var string|null */
    private $summary;

    /** @var string|null */
    private $description;

    /** @var Operation|null */
    private $get;

    /** @var Operation|null */
    private $put;

    /** @var Operation|null */
    private $post;

    /** @var Operation|null */
    private $delete;

    /** @var Operation|null */
    private $options;

    /** @var Operation|null */
    private $head;

    /** @var Operation|null */
    private $patch;

    /** @var Operation|null */
    private $trace;

    /** @var Server[] */
    private $servers;

    /** @var Parameters */
    private $parameters;

    public function __construct(array $data = [])
    {
        $this->ref = $data['ref'] ?? null;
        $this->summary = $data['summary'] ?? null;
        $this->description = $data['description'] ?? null;

        foreach (self::$methods as $method) {
            $this->{$method} = isset($data[$method]) ? new Operation($data[$method]) : null;
        }

        $this->servers = instantiateBulk(Server::class, $data['servers'] ?? []);
        $this->parameters = new Parameters($data['parameters'] ?? []);

        $this->mergeExtensions($data);
    }

    protected function export(): array
    {
        $return = [];

        if (null !== $this->summary) {
            $return['summary'] = $this->summary;
        }

        if (null !== $this->description) {
            $return['description'] = $this->description;
        }

        foreach (self::$methods as $method) {
            if ($this->$method) {
                $return[$method] = $this->$method;
            }
        }

        if (count($this->servers) !== 0) {
            $return['servers'] = $this->servers;
        }

        if (!$this->parameters->isEmpty()) {
            $return['parameters'] = $this->parameters;
        }

        return $return;
    }
}
