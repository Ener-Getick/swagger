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

use EXSyst\OAS\Collections\Callbacks;
use EXSyst\OAS\Collections\Content;
use EXSyst\OAS\Collections\Headers;
use EXSyst\OAS\Collections\Links;

final class Response extends AbstractObject
{
    use ExtensionPart;

    /** @var string|null */
    private $description;

    /** @var Headers */
    private $headers;

    /** @var Content */
    private $content;

    /** @var Callbacks */
    private $callback;

    private $links;

    public function __construct(array $data)
    {
        $this->description = $data['description'] ?? null;
        $this->headers = new Headers($data['headers'] ?? []);
        $this->content = new Content($data['content'] ?? []);
        $this->callback = new Callbacks($data['callback'] ?? []);
        $this->links = new Links($data['links'] ?? []);
    }

    protected function export(): array
    {
        $return = [];

        if (null !== $this->description) {
            $return['description'] = $this->description;
        }

        if (!$this->content->isEmpty()) {
            $return['content'] = $this->content;
        }

        if (!$this->headers->isEmpty()) {
            $return['headers'] = $this->headers;
        }

        if (!$this->links->isEmpty()) {
            $return['links'] = $this->links;
        }

        return $return;
    }
}
