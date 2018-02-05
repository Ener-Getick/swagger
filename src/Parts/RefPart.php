<?php

/*
 * This file is part of the Swagger package.
 *
 * (c) EXSyst
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EXSyst\Component\Swagger\Parts;

/**
 * @internal
 */
trait RefPart
{
    /** @var string */
    private $ref;

    private function mergeRef(array $data, $overwrite)
    {
        $this->ref = $data['$ref'] ?? null;
    }

    /**
     * @return string
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * @param string|null $ref
     *
     * @return RefPart
     */
    public function setRef($ref)
    {
        $this->ref = $ref;

        return $this;
    }

    public function hasRef()
    {
        return null !== $this->ref;
    }
}
