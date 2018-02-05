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
use EXSyst\Component\Swagger\Header;

final class Headers extends AbstractModel implements \IteratorAggregate
{
    const REQUIRED = false;

    private $headers = [];

    public function __construct($data = [])
    {
        $this->merge($data);
    }

    protected function doMerge($data, $overwrite = false)
    {
        foreach ($data as $name => $header) {
            $this->get($name)->merge($header, $overwrite);
        }
    }

    protected function doExport(): array
    {
        return $this->headers;
    }

    /**
     * Returns whether a header with the given name exists.
     */
    public function has(string $header): bool
    {
        return isset($this->headers[$header]);
    }

    /**
     * Returns the header info for the given code.
     */
    public function get($header): Header
    {
        if (!$this->has($header)) {
            $this->set($header, new Header());
        }

        return $this->headers[$header];
    }

    /**
     * Sets the header.
     */
    public function set(string $name, Header $header): self
    {
        $this->headers[$name] = $header;

        return $this;
    }

    /**
     * Removes the given header.
     */
    public function remove(string $header): self
    {
        unset($this->headers[$header]);

        return $this;
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->headers);
    }
}
