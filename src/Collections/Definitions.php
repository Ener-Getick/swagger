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
use EXSyst\Component\Swagger\Schema;

final class Definitions extends AbstractModel implements \IteratorAggregate
{
    const REQUIRED = false;

    private $definitions = [];

    public function __construct($data = [])
    {
        $this->merge($data);
    }

    protected function doMerge($data, $overwrite = false)
    {
        foreach ($data as $name => $schema) {
            $this->get($name)->merge($schema, $overwrite);
        }
    }

    protected function doExport(): array
    {
        return $this->definitions;
    }

    /**
     * Returns the schema for the given field.
     */
    public function get(string $name): Schema
    {
        if (!$this->has($name)) {
            $this->set($name, new Schema());
        }

        return $this->definitions[$name];
    }

    /**
     * Sets the field.
     */
    public function set(string $name, Schema $schema): self
    {
        $this->definitions[$name] = $schema;

        return $this;
    }

    /**
     * Removes the given field.
     */
    public function remove(string $name): self
    {
        unset($this->definitions[$name]);

        return $this;
    }

    /**
     * Returns definitions has a schema with the given name.
     */
    public function has(string $name): bool
    {
        return isset($this->definitions[$name]);
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->definitions);
    }
}
