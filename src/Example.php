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

final class Example extends AbstractObject
{
    use ExtensionPart;

    /** @var string|null */
    private $summary;

    /** @var string|null */
    private $description;

    /** @var mixed */
    private $value;

    /** @var string|null */
    private $externalValue;

    public function __construct(array $data = [])
    {
        $this->summary = $data['summary'] ?? null;
        $this->description = $data['description'] ?? null;
        $this->value = $data['value'] ?? null;
        $this->externalValue = $data['externalValue'] ?? null;

        $this->mergeExtensions($data);
    }

    protected function export(): array
    {
        $return = [];

        if (null !== $this->summary) {
            $return['summary'] = $this->summary;
        }

        if (null !== $this->description) {
            $return['description'] = $this->description;
        }

        if (null !== $this->value) {
            $return['value'] = $this->value;
        }

        if (null !== $this->externalValue) {
            $return['externalValue'] = $this->externalValue;
        }

        return $return;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(?string $summary): self
    {
        $this->summary = $summary;

        return $this;
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

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @var mixed $value
     */
    public function setValue($value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getExternalValue(): ?string
    {
        return $this->externalValue;
    }

    public function setExternalValue(?string $externalValue): self
    {
        $this->externalValue = $externalValue;

        return $this;
    }
}
