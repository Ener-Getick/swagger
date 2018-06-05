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

final class Header extends AbstractObject
{
    use ExtensionPart;

    /** @var string */
    private $description;

    /** @var Schema|Reference|null */
    private $schema;

    public function __construct(array $data)
    {
        $this->description = $data['description'] ?? null;
        $this->schema = isset($data['schema']) ? referenceOr(Schema::class, $data['schema']) : null;

        $this->mergeExtensions($data);
    }

    public function export(): array
    {
        $return = [
            'schema' => $this->schema,
        ];

        if (null !== $this->description) {
            $return['description'] = $this->description;
        }

        return $return;
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
}
