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
trait SchemesPart
{
    private $schemes = [];

    private function mergeSchemes(array $data, bool $overwrite)
    {
        foreach ($data['schemes'] ?? [] as $scheme) {
            $this->schemes[$scheme] = true;
        }
    }

    /**
     * Return schemes.
     */
    public function getSchemes(): array
    {
        return array_keys($this->schemes);
    }
}
