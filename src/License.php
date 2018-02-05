<?php

/*
 * This file is part of the Swagger package.
 *
 * (c) EXSyst
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EXSyst\Component\Swagger;

use EXSyst\Component\Swagger\Parts\ExtensionPart;
use EXSyst\Component\Swagger\Parts\UrlPart;
use EXSyst\Component\Swagger\Util\MergeHelper;

final class License extends AbstractModel
{
    const REQUIRED = false;

    use UrlPart;
    use ExtensionPart;

    /** @var string */
    private $name;

    public function __construct($data = [])
    {
        $this->merge($data);
    }

    protected function doMerge($data, $overwrite = false)
    {
        MergeHelper::mergeFields($this->name, $data['name'] ?? null, $overwrite);

        $this->mergeExtensions($data, $overwrite);
        $this->mergeUrl($data, $overwrite);
    }

    protected function doExport(): array
    {
        return [
            'name' => $this->name,
            'url' => $this->url,
        ];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name): self
    {
        $this->name = $name;

        return $this;
    }
}
