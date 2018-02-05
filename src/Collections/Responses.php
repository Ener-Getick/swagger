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
use EXSyst\Component\Swagger\Response;

final class Responses extends AbstractModel implements \IteratorAggregate
{
    use ExtensionPart;

    private $responses = [];

    public function __construct($data = [])
    {
        $this->merge($data);
    }

    protected function doMerge($data, $overwrite = false)
    {
        $this->mergeExtensions($data, $overwrite);

        foreach ($data as $code => $response) {
            if (0 !== strpos($code, 'x-')) {
                $this->set($code, new Response($response));
            }
        }
    }

    protected function doExport(): array
    {
        return $this->responses;
    }

    /**
     * Returns whether the given response exists.
     */
    public function has($code): bool
    {
        return isset($this->responses[$code]);
    }

    /**
     * Returns the response info for the given code.
     */
    public function get($code): Response
    {
        if (!$this->has($code)) {
            $this->set($code, new Response());
        }

        return $this->responses[$code];
    }

    /**
     * Sets the response.
     */
    public function set($code, Response $response): self
    {
        $this->responses[$code] = $response;

        return $this;
    }

    /**
     * Removes the given response.
     */
    public function remove($code): self
    {
        unset($this->responses[$code]);

        return $this;
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->responses);
    }
}
