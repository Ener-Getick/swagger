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
trait SecurityPart
{
    /** @var array */
    private $security;

    private function mergeSecurity(array $data, bool $overwrite)
    {
        MergeHelper::mergeFields($this->security, $data['security'] ?? null, $overwrite);
    }

    /**
     * @return array|null
     */
    public function getSecurity()
    {
        return $this->security;
    }

    public function setSecurity(array $security = null): self
    {
        $this->security = $security;

        return $this;
    }
}
