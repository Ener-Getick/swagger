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
use EXSyst\Component\Swagger\Parts\ExtensionPart;
use EXSyst\Component\Swagger\Path;

final class Paths extends AbstractModel implements \IteratorAggregate
{
    const REQUIRED = false;

    use ExtensionPart;

    private $paths = [];

    public function __construct($data = [])
    {
        $this->merge($data);
    }

    protected function doMerge($data, $overwrite = false)
    {
        foreach ($data as $key => $path) {
            if (0 !== strpos($key, 'x-')) {
                $this->get($key)->merge($path, $overwrite);
            }
        }

        $this->mergeExtensions($data, $overwrite);
    }

    protected function doExport(): array
    {
        return $this->paths;
    }

    /**
     * Returns whether a path with the given name exists.
     */
    public function has(string $path): bool
    {
        return isset($this->paths[$path]);
    }

    /**
     * Returns the path info for the given path.
     */
    public function get(string $path): Path
    {
        if (!$this->has($path)) {
            $this->set($path, new Path());
        }

        return $this->paths[$path];
    }

    /**
     * Sets the path.
     */
    public function set(string $path, Path $model): self
    {
        $this->paths[$path] = $model;

        return $this;
    }

    /**
     * Removes the given path.
     */
    public function remove(string $path): self
    {
        unset($this->paths[$path]);

        return $this;
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->paths);
    }
}
