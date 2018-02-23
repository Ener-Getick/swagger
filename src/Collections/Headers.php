<?php

/*
 * This file is part of the Swagger package.
 *
 * (c) EXSyst
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EXSyst\OAS\Collections;

use EXSyst\OAS\AbstractObject;
use EXSyst\OAS\Header;
use function EXSyst\OAS\referenceOr;

/**
 * Helper class - Does not exist in actual Spec.
 */
final class Headers extends AbstractObject
{
    private $headers = [];

    public function __construct(array $data = [])
    {
        foreach ($data as $name => $header) {
            $this->headers[$name] = referenceOr(Header::class, $header);
        }
    }

    protected function export(): array
    {
        return $this->headers;
    }

    public function isEmpty(): bool
    {
        return empty($this->headers);
    }
}
