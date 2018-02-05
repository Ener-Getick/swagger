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

use EXSyst\Component\Swagger\Util\MergeHelper;

/**
 * @internal
 */
trait DescriptionPart
{
    /** @var string|null */
    private $description;

    private function mergeDescription(array $data, bool $overwrite)
    {
        MergeHelper::mergeFields($this->description, $data['description'] ?? null, $overwrite);
    }

    /**
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return $this
     */
    public function setDescription(string $description = null): self
    {
        $this->description = $description;

        return $this;
    }
}
