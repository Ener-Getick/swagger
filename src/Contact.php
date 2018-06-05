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

final class Contact extends AbstractObject
{
    use ExtensionPart;

    /** @var string|null */
    private $name;

    /** @var string|null */
    private $url;

    /** @var string|null */
    private $email;

    public function __construct(array $data = [])
    {
        $this->name = $data['name'] ?? null;
        $this->url = $data['url'] ?? null;
        $this->email = $data['email'] ?? null;

        $this->mergeExtensions($data);
    }

    protected function export(): array
    {
        $return = [];

        if (null !== $this->name) {
            $return['name'] = $this->name;
        }

        if (null !== $this->url) {
            $return['url'] = $this->url;
        }

        if (null !== $this->email) {
            $return['email'] = $this->email;
        }

        return $return;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }
}
