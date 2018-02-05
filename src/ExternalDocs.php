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

use EXSyst\Component\Swagger\Parts\DescriptionPart;
use EXSyst\Component\Swagger\Parts\ExtensionPart;
use EXSyst\Component\Swagger\Parts\UrlPart;

final class ExternalDocs extends AbstractModel
{
    const REQUIRED = false;

    use DescriptionPart;
    use UrlPart;
    use ExtensionPart;

    public function __construct($data = [])
    {
        $this->merge($data);
    }

    protected function doMerge($data, $overwrite = false)
    {
        $this->mergeDescription($data, $overwrite);
        $this->mergeExtensions($data, $overwrite);
        $this->mergeUrl($data, $overwrite);
    }

    protected function doExport(): array
    {
        return [
            'description' => $this->description,
            'url' => $this->url,
        ];
    }
}
