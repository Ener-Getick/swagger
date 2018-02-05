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

use EXSyst\Component\Swagger\Items;

/**
 * @internal
 */
trait ItemsPart
{
    /** @var Items|null */
    private $items;

    private function mergeItems(array $data, bool $overwrite)
    {
        if (isset($data['items'])) {
            $this->getItems()->merge($data['items'], $overwrite);
        }
    }

    /**
     * Returns the items.
     */
    public function getItems(): Items
    {
        if (null === $this->items) {
            $this->items = new Items();
        }

        return $this->items;
    }
}
