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

use EXSyst\Component\Swagger\Collections\Headers;
use EXSyst\Component\Swagger\Parts\DescriptionPart;
use EXSyst\Component\Swagger\Parts\ExtensionPart;
use EXSyst\Component\Swagger\Parts\RefPart;
use EXSyst\Component\Swagger\Parts\SchemaPart;
use EXSyst\Component\Swagger\Util\MergeHelper;

final class Response extends AbstractModel
{
    use RefPart;
    use DescriptionPart;
    use SchemaPart;
    use ExtensionPart;

    private $examples = [];

    /** @var Headers */
    private $headers;

    public function __construct($data = [])
    {
        $this->headers = new Headers();

        $this->merge($data);
    }

    protected function doMerge($data, $overwrite = false)
    {
        foreach ($data['examples'] ?? [] as $mimeType => $example) {
            $this->examples[$mimeType] = $this->examples[$mimeType] ?? null;
            MergeHelper::mergeFields($this->examples[$mimeType], $example, $overwrite);
        }

        $this->headers->merge($data['headers'] ?? [], $overwrite);

        $this->mergeDescription($data, $overwrite);
        $this->mergeExtensions($data, $overwrite);
        $this->mergeRef($data, $overwrite);
        $this->mergeSchema($data, $overwrite);
    }

    protected function doExport(): array
    {
        if ($this->hasRef()) {
            return ['$ref' => $this->getRef()];
        }

        return [
            'description' => $this->description,
            'schema' => $this->schema,
            'headers' => $this->headers,
            'examples' => $this->examples ?: null,
        ];
    }

    public function getExamples(): array
    {
        return $this->examples;
    }

    /**
     * Returns headers for this response.
     */
    public function getHeaders(): Headers
    {
        return $this->headers;
    }
}
