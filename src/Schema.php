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

use EXSyst\Component\Swagger\Collections\Definitions;
use EXSyst\Component\Swagger\Parts\DescriptionPart;
use EXSyst\Component\Swagger\Parts\ExtensionPart;
use EXSyst\Component\Swagger\Parts\ExternalDocsPart;
use EXSyst\Component\Swagger\Parts\ItemsPart;
use EXSyst\Component\Swagger\Parts\RefPart;
use EXSyst\Component\Swagger\Parts\TypePart;
use EXSyst\Component\Swagger\Util\MergeHelper;

class Schema extends AbstractModel
{
    use RefPart;
    use TypePart;
    use DescriptionPart;
    use ItemsPart;
    use ExternalDocsPart;
    use ExtensionPart;

    /** @var string */
    private $discriminator;

    /** @var bool */
    private $readOnly;

    /** @var string */
    private $title;

    /** @var string */
    private $example;

    /** @var array|bool */
    private $required;

    /** @var Definitions */
    private $properties;

    /** @var array */
    private $allOf = [];

    /** @var Schema */
    private $additionalProperties;

    public function __construct($data = [])
    {
        $this->properties = new Definitions();
        $this->merge($data);
    }

    protected function doMerge($data, $overwrite = false)
    {
        MergeHelper::mergeFields($this->required, $data['required'] ?? null, $overwrite);
        MergeHelper::mergeFields($this->title, $data['title'] ?? null, $overwrite);
        MergeHelper::mergeFields($this->discriminator, $data['discriminator'] ?? null, $overwrite);
        MergeHelper::mergeFields($this->readOnly, $data['readOnly'] ?? null, $overwrite);
        MergeHelper::mergeFields($this->example, $data['example'] ?? null, $overwrite);

        $this->properties->merge($data['properties'] ?? [], $overwrite);

        foreach ($data['allOf'] ?? [] as $schema) {
            $this->allOf[] = new self($schema);
        }

        if (isset($data['additionalProperties'])) {
            if (null === $this->additionalProperties) {
                $this->additionalProperties = new self();
            }

            $this->additionalProperties->merge($data['additionalProperties'], $overwrite);
        }

        $this->mergeDescription($data, $overwrite);
        $this->mergeExternalDocs($data, $overwrite);
        $this->mergeExtensions($data, $overwrite);
        $this->mergeItems($data, $overwrite);
        $this->mergeRef($data, $overwrite);
        $this->mergeType($data, $overwrite);
    }

    protected function doExport()
    {
        if ($this->hasRef()) {
            return ['$ref' => $this->getRef()];
        }

        /*
         * if additionalProperties has no special types/refs, it should return {} or true
         *  according to https://swagger.io/docs/specification/data-models/dictionaries/
         * Without the following code, it returns a [], which is wrong/not valid.
         */
        if ($this->additionalProperties instanceof self) {
            $this->additionalProperties = $this->additionalProperties->toArray();
            if ($this->additionalProperties === []) {
                $this->additionalProperties = new \stdClass();
            }
        }

        return array_merge([
            'title' => $this->title,
            'discriminator' => $this->discriminator,
            'description' => $this->description,
            'readOnly' => $this->readOnly,
            'example' => $this->example,
            'externalDocs' => $this->externalDocs,
            'items' => $this->items,
            'required' => $this->required,
            'properties' => $this->properties,
            'additionalProperties' => $this->additionalProperties,
            'allOf' => $this->allOf ?: null,
        ], $this->doExportType());
    }

    /**
     * @return bool|array
     */
    public function getRequired()
    {
        return $this->required;
    }

    /**
     * @param bool|array $required
     *
     * @return $this
     */
    public function setRequired($required)
    {
        $this->required = $required;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDiscriminator()
    {
        return $this->discriminator;
    }

    /**
     * @param string|null $discriminator
     *
     * @return Schema
     */
    public function setDiscriminator($discriminator)
    {
        $this->discriminator = $discriminator;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function isReadOnly()
    {
        return $this->readOnly;
    }

    /**
     * @param bool|null $readOnly
     *
     * @return Schema
     */
    public function setReadOnly($readOnly)
    {
        $this->readOnly = $readOnly;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getExample()
    {
        return $this->example;
    }

    /**
     * @param string|null $example
     *
     * @return Schema
     */
    public function setExample($example)
    {
        $this->example = $example;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Definitions
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @return array
     */
    public function getAllOf(): array
    {
        return $this->allOf;
    }

    /**
     * @return Schema|null
     */
    public function getAdditionalProperties()
    {
        return $this->additionalProperties;
    }
}
