<?php

/*
 * This file is part of the Swagger package.
 *
 * (c) EXSyst
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EXSyst\OAS;

use EXSyst\OAS\Collections\Schemas;

class Schema extends AbstractObject
{
    use ExtensionPart;

    private $title;

    private $multipleOf;

    private $maximum;

    private $exclusiveMaximum;

    private $minimum;

    private $exclusiveMinimum;

    private $maxLength;

    private $minLength;

    private $pattern;

    private $maxItems;

    private $minItems;

    private $uniqueItems;

    private $maxProperties;

    private $minProperties;

    /** @var string[]|null */
    private $required;

    private $enum;

    /** @var string */
    private $type;

    /** @var Reference[]|Schema[]|Schemas */
    private $allOf;

    private $oneOf;

    private $anyOf;

    private $not;

    /** @var Schema|Reference|null */
    private $items;

    /** @var Schemas|Schema[]|Reference[] */
    private $properties;

    /** @var bool|Schema|Reference */
    private $additionalProperties;

    /** @var string|null */
    private $description;

    /** @var string|null */
    private $format;

    /** @var mixed */
    private $default;

    private $nullable;

    private $discriminator;

    private $readOnly;

    private $writeOnly;

    private $xml;

    private $externalDocs;

    /** @var string|null */
    private $example;

    private $deprecated;


    public function __construct(array $data)
    {
        $this->type = $data['type'] ?? null;

        if (isset($data['allOf'])) {
            $this->allOf = instantiateBulk(Schema::class, $data['allOf']);
        }

        $this->example = $data['example'] ?? null;
        $this->default = $data['default'] ?? null;
        $this->description = $data['description'] ?? null;
        if (isset($data['additionalProperties'])) {
            $this->additionalProperties = is_bool($data['additionalProperties']) ?
                $data['additionalProperties'] :
                referenceOr(Schema::class, $data['additionalProperties']);
        }
        $this->required = $data['required'] ?? null;
        $this->items = isset($data['items']) ? referenceOr(Schema::class, $data['items']) : null;
        $this->properties = new Schemas($data['properties'] ?? []);
        $this->format = $data['format'] ?? null;
    }

    protected function export(): array
    {
        $return = [];

        if (!is_null($this->required)) {
            $return['required'] = $this->required;
        }

        if (null !== $this->type) {
            $return['type'] = $this->type;
        }

        if (null !== $this->description) {
            $return['description'] = $this->description;
        }

        if (null !== $this->items) {
            $return['items'] = $this->items;
        }

        if (!$this->properties->isEmpty()) {
            $return['properties'] = $this->properties;
        }

        if (null !== $this->format) {
            $return['format'] = $this->format;
        }

        if (null !== $this->example) {
            $return['example'] = $this->example;
        }

        if (null !== $this->additionalProperties) {
            $return['additionalProperties'] = $this->additionalProperties;
        }

        if (null !== $this->default) {
            $return['default'] = $this->default;
        }

        if (null !== $this->allOf) {
            $return['allOf'] = $this->allOf;
        }

        return $return;
    }
}
