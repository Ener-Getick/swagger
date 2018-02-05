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
trait TypePart
{
    /** @var string */
    private $type;

    /** @var string */
    private $format;

    /** @var string */
    private $collectionFormat;

    /** @var mixed */
    private $default;

    /** @var float */
    private $maximum;

    /** @var bool */
    private $exclusiveMaximum;

    /** @var float */
    private $minimum;

    /** @var bool */
    private $exclusiveMinimum;

    /** @var int */
    private $maxLength;

    /** @var int */
    private $minLength;

    /** @var string */
    private $pattern;

    /** @var int */
    private $maxItems;

    /** @var int */
    private $minItems;

    /** @var bool */
    private $uniqueItems;

    /** @var mixed */
    private $enum;

    /** @var float */
    private $multipleOf;

    private function mergeType(array $data, bool $overwrite)
    {
        foreach ($this->getTypeFields() as $field) {
            MergeHelper::mergeFields($this->{$field}, $data[$field] ?? null, $overwrite);
        }
    }

    protected function doExportType()
    {
        $return = [];
        foreach ($this->getTypeFields() as $field) {
            $return[$field] = $this->{$field};
        }

        return $return;
    }

    private function getTypeFields(): array
    {
        return ['type', 'format', 'collectionFormat', 'default', 'maximum', 'exclusiveMaximum', 'minimum', 'exclusiveMinimum', 'maxLength', 'minLength', 'pattern', 'maxItems', 'minItems', 'uniqueItems', 'enum', 'multipleOf'];
    }

    /**
     * @return string|null
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     *
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * Sets the extending format for the type.
     *
     * @param string|null $format
     *
     * @return $this
     */
    public function setFormat($format)
    {
        $this->format = $format;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCollectionFormat()
    {
        return $this->collectionFormat;
    }

    /**
     * Determines the format of the array if type array is used. Possible values are:.
     *
     * - `csv` - comma separated values `foo,bar`.
     * - `ssv` - space separated values `foo bar`.
     * - `tsv` - tab separated values `foo\tbar`.
     * - `pipes` - pipe separated values `foo|bar`.
     * - `multi` - corresponds to multiple parameter instances instead of multiple values for a
     * single instance `foo=bar&foo=baz`. This is valid only for parameters in "query" or "formData".
     *
     * Default value is `csv`.
     *
     *
     * @param string|null $collectionFormat
     *
     * @return $this
     */
    public function setCollectionFormat($collectionFormat)
    {
        $this->collectionFormat = $collectionFormat;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * @param mixed|null $default
     *
     * @return $this
     */
    public function setDefault($default)
    {
        $this->default = $default;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getMaximum()
    {
        return $this->maximum;
    }

    /**
     * @param float|null $maximum
     *
     * @return $this
     */
    public function setMaximum($maximum)
    {
        $this->maximum = $maximum;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function isExclusiveMaximum()
    {
        return $this->exclusiveMaximum;
    }

    /**
     * @param bool|null $exclusiveMaximum
     *
     * @return $this
     */
    public function setExclusiveMaximum($exclusiveMaximum)
    {
        $this->exclusiveMaximum = $exclusiveMaximum;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getMinimum()
    {
        return $this->minimum;
    }

    /**
     * @param float|null $minimum
     *
     * @return $this
     */
    public function setMinimum($minimum)
    {
        $this->minimum = $minimum;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function isExclusiveMinimum()
    {
        return $this->exclusiveMinimum;
    }

    /**
     * @param bool|null $exclusiveMinimum
     *
     * @return $this
     */
    public function setExclusiveMinimum($exclusiveMinimum)
    {
        $this->exclusiveMinimum = $exclusiveMinimum;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getMaxLength()
    {
        return $this->maxLength;
    }

    /**
     * @param int|null $maxLength
     *
     * @return $this
     */
    public function setMaxLength($maxLength)
    {
        $this->maxLength = $maxLength;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getMinLength()
    {
        return $this->minLength;
    }

    /**
     * @param int|null $minLength
     *
     * @return $this
     */
    public function setMinLength($minLength)
    {
        $this->minLength = $minLength;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPattern()
    {
        return $this->pattern;
    }

    /**
     * @param string|null $pattern
     *
     * @return $this
     */
    public function setPattern($pattern)
    {
        $this->pattern = $pattern;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getMaxItems()
    {
        return $this->maxItems;
    }

    /**
     * @param int|null $maxItems
     *
     * @return $this
     */
    public function setMaxItems($maxItems)
    {
        $this->maxItems = $maxItems;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getMinItems()
    {
        return $this->minItems;
    }

    /**
     * @param int|null $minItems
     *
     * @return $this
     */
    public function setMinItems($minItems)
    {
        $this->minItems = $minItems;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function hasUniqueItems()
    {
        return $this->uniqueItems;
    }

    /**
     * @param bool|null $uniqueItems
     *
     * @return $this
     */
    public function setUniqueItems($uniqueItems)
    {
        $this->uniqueItems = $uniqueItems;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEnum()
    {
        return $this->enum;
    }

    /**
     * @param mixed $enum
     *
     * @return $this
     */
    public function setEnum($enum)
    {
        $this->enum = $enum;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getMultipleOf()
    {
        return $this->multipleOf;
    }

    /**
     * @param float|null $multipleOf
     *
     * @return $this
     */
    public function setMultipleOf($multipleOf)
    {
        $this->multipleOf = $multipleOf;

        return $this;
    }
}
