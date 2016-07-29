<?php

/*
 * This file is part of the Swagger package.
 *
 * (c) EXSyst
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EXSyst\Swagger\Collections;

use EXSyst\Swagger\Header;
use EXSyst\Swagger\AbstractModel;

final class Headers extends AbstractModel
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

    protected function doExport()
    {
        return $this->headers;
    }

    /**
     * Returns whether a header with the given name exists.
     *
     * @param string $header
     *
     * @return bool
     */
    public function has($header)
    {
        return isset($this->headers[$header]);
    }

    /**
     * Returns the header info for the given code.
     *
     * @param string $header
     *
     * @return Header
     */
    public function get($header)
    {
        if (!$this->has($header)) {
            $this->set($header, new Header());
        }

        return $this->headers[$header];
    }

    /**
     * Sets the header.
     *
     * @param Header $header
     */
    public function set($name, Header $header)
    {
        $this->headers[$name] = $header;

        return $this;
    }

    /**
     * Removes the given header.
     *
     * @param string $header
     */
    public function remove($header)
    {
        unset($this->headers[$header]);

        return $this;
    }
}
