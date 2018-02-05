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
use EXSyst\Component\Swagger\Parts\ItemsPart;
use EXSyst\Component\Swagger\Parts\RefPart;
use EXSyst\Component\Swagger\Parts\RequiredPart;
use EXSyst\Component\Swagger\Parts\SchemaPart;
use EXSyst\Component\Swagger\Parts\TypePart;
use EXSyst\Component\Swagger\Util\MergeHelper;

final class Parameter extends AbstractModel
{
    use RefPart;
    use DescriptionPart;
    use SchemaPart;
    use TypePart;
    use ItemsPart;
    use RequiredPart;
    use ExtensionPart;

    /** @var string */
    private $name;

    /** @var string */
    private $in;

    /** @var bool|null */
    private $allowEmptyValue;

    public function __construct($data = [])
    {
        $data = $this->normalize($data);
        $this->merge($data);

        if (!$this->hasRef()) {
            if (!isset($data['name']) || !isset($data['in'])) {
                throw new \InvalidArgumentException('"in" and "name" are required for parameters');
            }

            $this->name = $data['name'];
            $this->in = $data['in'];
        }
    }

    protected function doMerge($data, $overwrite = false)
    {
        MergeHelper::mergeFields($this->allowEmptyValue, $data['allowEmptyValue'] ?? null, $overwrite);

        $this->mergeDescription($data, $overwrite);
        $this->mergeExtensions($data, $overwrite);
        $this->mergeItems($data, $overwrite);
        $this->mergeRef($data, $overwrite);
        $this->mergeRequired($data, $overwrite);
        $this->mergeSchema($data, $overwrite);
        $this->mergeType($data, $overwrite);
    }

    protected function doExport(): array
    {
        if ($this->hasRef()) {
            return ['$ref' => $this->getRef()];
        }

        return array_merge(
            [
                'name' => $this->name,
                'in' => $this->in,
                'allowEmptyValue' => $this->allowEmptyValue,
                'required' => $this->required,
                'description' => $this->description,
                'schema' => $this->schema,
                'items' => $this->items,
            ],
            $this->doExportType()
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getIn()
    {
        return $this->in;
    }

    /**
     * @return bool
     */
    public function getAllowEmptyValue()
    {
        return $this->allowEmptyValue;
    }

    /**
     * Sets the ability to pass empty-valued parameters. This is valid only for either `query` or
     * `formData` parameters and allows you to send a parameter with a name only or an empty value.
     * Default value is `false`.
     *
     * @param bool $allowEmptyValue
     */
    public function setAllowEmptyValue($allowEmptyValue): self
    {
        $this->allowEmptyValue = $allowEmptyValue;

        return $this;
    }
}
