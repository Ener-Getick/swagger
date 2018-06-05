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

    /** @var Schema|Reference */
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
}
