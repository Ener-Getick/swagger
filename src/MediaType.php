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

use EXSyst\OAS\Collections\Examples;

final class MediaType extends AbstractObject
{
    use ExtensionPart;

    /** @var Schema */
    private $schema;

    /** @var Examples|Example[]|Reference[] */
    private $examples;

    /** @var mixed */
    private $example;

    public function __construct(array $data = [])
    {
        $this->schema = isset($data['schema']) ? referenceOr(Schema::class, $data['schema']) : null;
        $this->examples = new Examples($data['examples'] ?? []);
        $this->example = $data['example'] ?? null;

        $this->mergeExtensions($data);
    }

    protected function export(): array
    {
        $return = [];

        if (null !== $this->schema) {
            $return['schema'] = $this->schema;
        }

        if (!$this->examples->isEmpty()) {
            $return['examples'] = $this->examples;
        }

        if (null !== $this->example) {
            $return['example'] = $this->example;
        }

        return $return;
    }
}
