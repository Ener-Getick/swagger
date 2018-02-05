<?php

/*
 * This file is part of the Swagger package.
 *
 * (c) EXSyst
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EXSyst\Component\Swagger;

use EXSyst\Component\Swagger\Parts\ExtensionPart;
use EXSyst\Component\Swagger\Parts\ParametersPart;

final class Path extends AbstractModel
{
    use ExtensionPart;
    use ParametersPart;

    private $operations = [];

    public function __construct($data = [])
    {
        $this->merge($data);
    }

    protected function doMerge($data, $overwrite = false)
    {
        foreach (Swagger::$METHODS as $method) {
            if (isset($data[$method])) {
                $this->getOperation($method)->merge($data[$method]);
            }
        }
        $this->mergeExtensions($data, $overwrite);
        $this->mergeParameters($data, $overwrite);
    }

    protected function doExport(): array
    {
        return array_merge($this->operations, array('parameters' => $this->getParameters()));
    }

    public function getOperations(): array
    {
        return $this->operations;
    }

    /**
     * Gets the operation for the given method, creates one if none exists.
     */
    public function getOperation(string $method): Operation
    {
        if (!$this->hasOperation($method)) {
            $this->setOperation($method, new Operation());
        }

        return $this->operations[$method];
    }

    /**
     * Sets the operation for a method.
     */
    public function setOperation(string $method, Operation $operation): self
    {
        $this->operations[$method] = $operation;

        return $this;
    }

    public function hasOperation(string $method): bool
    {
        return isset($this->operations[$method]);
    }

    /**
     * Removes an operation for the given method.
     */
    public function removeOperation(string $method): self
    {
        unset($this->operations[$method]);

        return $this;
    }

    /**
     * Returns all methods for this path.
     */
    public function getMethods(): array
    {
        return array_keys($this->operations);
    }
}
