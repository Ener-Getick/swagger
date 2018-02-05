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
trait ExtensionPart
{
    private $extensions = [];

    private function mergeExtensions(array $data, bool $overwrite)
    {
        foreach ($data as $name => $value) {
            if (0 === strpos($name, 'x-')) {
                $this->extensions[substr($name, 2)] = $value;
            }
        }
    }

    /**
     * Returns extensions.
     *
     * @return array
     */
    public function getExtensions(): array
    {
        return $this->extensions;
    }
}
