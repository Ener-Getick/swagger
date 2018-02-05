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

        // responses
        foreach ($data as $code => $response) {
            if (0 !== strpos($code, 'x-')) {
                $this->set($code, new Response($response));
            }
        }
    }

    protected function doExport()
    {
        return $this->responses;
    }

    /**
     * Returns whether the given response exists.
     *
     * @param string $code
     *
     * @return bool
     */
    public function has($code)
    {
        return isset($this->responses[$code]);
    }

    /**
     * Returns the response info for the given code.
     *
     * @param string $code
     *
     * @return Response
     */
    public function get($code)
    {
        if (!$this->has($code)) {
            $this->set($code, new Response());
        }

        return $this->responses[$code];
    }

    /**
     * Sets the response.
     *
     * @param string   $code
     * @param Response $response
     *
     * @return Responses
     */
    public function set($code, Response $response)
    {
        $this->responses[$code] = $response;

        return $this;
    }

    /**
     * Removes the given response.
     *
     * @param string $code
     *
     * @return Responses
     */
    public function remove($code)
    {
        unset($this->responses[$code]);

        return $this;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->responses);
    }
}
