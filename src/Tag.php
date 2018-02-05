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
use EXSyst\Component\Swagger\Parts\ExternalDocsPart;

final class Tag extends AbstractModel
{
    use DescriptionPart;
    use ExternalDocsPart;
    use ExtensionPart;

    private $name;

    public function __construct($data)
    {
        $data = $this->normalize($data);
        if (!isset($data['name'])) {
            throw new \InvalidArgumentException('A tag must have a name.');
        }

        $this->name = $data['name'];
        $this->merge($data);
    }

    protected function doMerge($data, $overwrite = false)
    {
        $this->mergeDescription($data, $overwrite);
        $this->mergeExtensions($data, $overwrite);
        $this->mergeExternalDocs($data, $overwrite);
    }

    public function toArray()
    {
        $return = parent::toArray();
        if (1 === count($return)) {
            return $return['name'];
        }

        return $return;
    }

    protected function doExport(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'externalDocs' => $this->externalDocs,
        ];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string|array $data
     *
     * @return array
     */
    protected function normalize($data): array
    {
        if (is_string($data)) {
            return [
                'name' => $data,
            ];
        }

        return parent::normalize($data);
    }
}
