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

final class Parameter extends AbstractObject
{
    use ExtensionPart;

    const
        IN_QUERY = 'query',
        IN_HEADER = 'header',
        IN_PATH = 'path',
        IN_COOKIE = 'cookie';

    /** @var string */
    private $name;

    /** @var string */
    private $in;

    /** @var string|null */
    private $description;

    /** @var bool */
    private $required;

    /** @var bool */
    private $deprecated;

    /** @var bool */
    private $allowEmptyValue;

    /** @var Schema|Reference|null */
    private $schema;

    /** @var string|null */
    private $style;

    /** @var bool */
    private $explode;

    /** @var bool */
    private $allowReserved;

    private $content; // TODO:

    private $example; // TODO:

    private $examples; // TODO:

    public function __construct(array $data)
    {
        $this->name = $data['name'];
        $this->in = $data['in'];
        $this->description = $data['description'] ?? null;
        $this->required = $this->in === self::IN_PATH ? true : ($data['required'] ?? false);
        $this->deprecated = $data['deprecated'] ?? false;
        $this->allowEmptyValue = $this->in === self::IN_QUERY ? ($data['allowEmptyValue'] ?? false) : false;
        $this->style = $data['style'] ?? null;
        $this->schema = $data['schema'] ?? null;

        $this->mergeExtensions($data);
    }

    protected function export(): array
    {
        $return = [
            'name' => $this->name,
            'in'   => $this->in,
        ];

        if (null !== $this->description) {
            $return['description'] = $this->description;
        }

        if ($this->required) {
            $return['required'] = $this->required;
        }

        if ($this->deprecated) {
            $return['deprecated'] = $this->deprecated;
        }

        if ($this->allowEmptyValue) {
            $return['allowEmptyValue'] = $this->allowEmptyValue;
        }

        if (null !== $this->schema) {
            $return['schema'] = $this->schema;
        }

        if (null !== $this->style) {
            $return['style'] = $this->style;
        }

        if ($this->explode) {
            $return['explode'] = $this->explode;
        }

        if ($this->allowReserved) {
            $return['allowReserved'] = $this->allowReserved;
        }

        return $return;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getIn(): string
    {
        return $this->in;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function isRequired(): bool
    {
        return $this->required;
    }

    public function setRequired(bool $required): self
    {
        if (self::IN_PATH === $this->in) {
            throw new \LogicException(sprintf('%s::$required is not writable for path parameters.', __CLASS__));
        }

        $this->required = $required;

        return $this;
    }

    public function getDeprecated(): bool
    {
        return $this->deprecated;
    }

    public function setDeprecated(bool $deprecated): self
    {
        $this->deprecated = $deprecated;

        return $this;
    }

    public function getAllowEmptyValue(): bool
    {
        return $this->allowEmptyValue;
    }

    public function setAllowEmptyValue(bool $allowEmptyValue): self
    {
        $this->allowEmptyValue = $allowEmptyValue;

        return $this;
    }

    /**
     * @return Schema|Reference|null
     */
    public function getSchema()
    {
        return $this->schema;
    }

    /**
     * @var Schema|Reference|null $schema
     */
    public function setSchema($schema): self
    {
        $this->schema = $schema;

        return $this;
    }

    public function getStyle(): ?string
    {
        return $this->style;
    }

    public function setStyle(?string $style): self
    {
        $this->style = $style;

        return $this;
    }

    public function getExplode(): bool
    {
        return $this->explode;
    }

    public function setExplode(bool $explode): self
    {
        $this->explode = $explode;

        return $this;
    }

    public function getAllowReserved(): bool
    {
        return $this->allowReserved;
    }

    public function setAllowReserved(bool $allowReserved): self
    {
        $this->allowReserved = $allowReserved;

        return $this;
    }
}
