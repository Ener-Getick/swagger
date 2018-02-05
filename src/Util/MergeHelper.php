<?php

/*
 * This file is part of the Swagger package.
 *
 * (c) EXSyst
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EXSyst\Component\Swagger\Util;

/**
 * @internal
 */
class MergeHelper
{
    /**
     * @param string|int|array|null $original
     * @param string|int|array|null $external
     * @param bool                  $overwrite
     */
    public static function mergeFields(&$original, $external, $overwrite)
    {
        if ($overwrite) {
            $original = $external ?? $original;
        } else {
            $original = $original ?? $external;
        }
    }
}
