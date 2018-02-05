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

use EXSyst\Component\Swagger\Schema;

/**
 * @internal
 */
trait SchemaPart
{
    /** @var Schema|null */
    private $schema;

    private function mergeSchema(array $data, bool $overwrite)
    {
        if (isset($data['schema'])) {
            $this->getSchema()->merge($data['schema'], $overwrite);
        }
    }

    public function getSchema(): Schema
    {
        if (null === $this->schema) {
            $this->schema = new Schema();
        }

        return $this->schema ?: new Schema();
    }
}
