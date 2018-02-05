<?php

/*
 * This file is part of the Swagger package.
 *
 * (c) EXSyst
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EXSyst\Component\Swagger\Collections;

use EXSyst\Component\Swagger\AbstractModel;
use EXSyst\Component\Swagger\Parameter;
use EXSyst\Component\Swagger\Parts\RefPart;

final class Parameters extends AbstractModel implements \IteratorAggregate
{
    const REQUIRED = false;

    use RefPart;

    private $parameters = [];

    public function __construct($data = [])
    {
        $this->merge($data);
    }

    protected function doMerge($data, $overwrite = false)
    {
        $this->mergeRef($data, $overwrite);
        if (!$this->hasRef()) {
            foreach ($data as $parameter) {
                $this->add(new Parameter($parameter));
            }
        }
    }

    protected function doExport(): array
    {
        if ($this->hasRef()) {
            return ['$ref' => $this->getRef()];
        }

        return array_values($this->parameters);
    }

    /**
     * Searches whether a parameter with the given unique combination exists.
     */
    public function has(string $name, string $in = null): bool
    {
        $id = $in ? $name.'/'.$in : $name;

        return isset($this->parameters[$id]);
    }

    public function get(string $name, string $in = null): Parameter
    {
        if (!$this->has($name, $in)) {
            $this->add(
                new Parameter(['name' => $name, 'in' => $in])
            );
        }

        $id = $in ? $name.'/'.$in : $name;

        return $this->parameters[$id];
    }

    /**
     * Adds a parameter.
     */
    public function add(Parameter $parameter): self
    {
        $this->parameters[$this->getIdentifier($parameter)] = $parameter;

        return $this;
    }

    /**
     * Removes a parameter.
     */
    public function remove(Parameter $parameter): self
    {
        unset($this->parameters[$this->getIdentifier($parameter)]);

        return $this;
    }

    private function getIdentifier(Parameter $parameter)
    {
        if ($parameter->hasRef()) {
            return $parameter->getRef();
        }

        return $parameter->getName().'/'.$parameter->getIn();
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator(array_values($this->parameters));
    }
}
