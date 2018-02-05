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
trait RequiredPart
{
    /** @var bool|null */
    private $required;

    private function mergeRequired(array $data, bool $overwrite)
    {
        MergeHelper::mergeFields($this->required, $data['required'] ?? null, $overwrite);
    }

    /**
     * @return bool|null
     */
    public function getRequired()
    {
        return $this->required;
    }

    /**
     * @param bool|null $required
     */
    public function setRequired(bool $required = null): self
    {
        $this->required = $required;

        return $this;
    }
}
