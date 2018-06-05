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

use EXSyst\OAS\Collections\Links;
use EXSyst\OAS\Collections\Schemas;

final class Components extends AbstractObject
{
    /** @var Schemas|Schema[]|Reference[] */
    private $schemas;

    /** @var Links|Link[]|Reference[] */
    private $links;

    public function __construct(array $data)
    {
        $this->schemas = new Schemas($data['schemas'] ?? []);
        $this->links = new Links($data['links'] ?? []);
    }

    public function isEmpty(): bool
    {
        return
            $this->schemas->isEmpty() &&
            $this->links->isEmpty();
    }

    protected function export(): array
    {
        $return = [];

        if (!$this->schemas->isEmpty()) {
            $return['schemas'] = $this->schemas;
        }

        if (!$this->links->isEmpty()) {
            $return['links'] = $this->links;
        }

        return $return;
    }

    public function getSchemas(): Schemas
    {
        return $this->schemas;
    }

    public function setSchemas(Schemas $schemas): self
    {
        $this->schemas = $schemas;

        return $this;
    }

    public function getLinks(): Links
    {
        return $this->links;
    }

    public function setLinks(Links $links): self
    {
        $this->links = $links;

        return $this;
    }
}
