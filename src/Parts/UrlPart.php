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
trait UrlPart
{
    /** @var string|null */
    private $url;

    private function mergeUrl(array $data, bool $overwrite)
    {
        MergeHelper::mergeFields($this->url, $data['url'] ?? null, $overwrite);
    }

    /**
     * @return string|null
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url = null): self
    {
        $this->url = $url;

        return $this;
    }
}
