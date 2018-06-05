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

use EXSyst\OAS\Collections\ServerVariables;

final class Server extends AbstractObject
{
    use ExtensionPart;

    /** @var string */
    private $url;

    /** @var string|null */
    private $description;

    /** @var ServerVariables */
    private $variables;

    public function __construct(array $data)
    {
        $this->url = $data['url'];
        $this->description = $data['description'] ?? null;
        $this->variables = new ServerVariables($data['variables'] ?? []);

        $this->mergeExtensions($data);
    }

    protected function export(): array
    {
        $return = [
            'url' => $this->url,
        ];

        if (null !== $this->description) {
            $return['description'] = $this->description;
        }

        if (!$this->variables->isEmpty()) {
            $return['variables'] = $this->variables;
        }

        return $return;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

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
}
