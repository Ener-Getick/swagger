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

final class Info extends AbstractObject implements ExtensibleInterface
{
    use ExtensionPart;

    /** @var string|null */
    private $title;

    /** @var string|null */
    private $description;

    /** @var string|null */
    private $termsOfService;

    /** @var Contact|null */
    private $contact;

    /** @var License|null */
    private $license;

    /** @var string|null */
    private $version;

    public function __construct(array $data)
    {
        $this->title = $data['title'] ?? null;
        $this->description = $data['description'] ?? null;
        $this->termsOfService = $data['termsOfService'] ?? null;
        if (isset($data['contact'])) {
            $this->contact = new Contact($data['contact']);
        }
        if (isset($data['license'])) {
            $this->license = new License($data['license']);
        }
        $this->version = $data['version'] ?? null;

        $this->mergeExtensions($data);
    }

    protected function export(): array
    {
        $return = [
            'title'   => $this->title,
            'version' => $this->version,
        ];

        if (null !== $this->description) {
            $return['description'] = $this->description;
        }

        if (null !== $this->termsOfService) {
            $return['termsOfService'] = $this->termsOfService;
        }

        if (null !== $this->contact) {
            $return['contact'] = $this->contact;
        }

        if (null !== $this->license) {
            $return['license'] = $this->license;
        }

        return $return;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

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

    public function getTermsOfService(): ?string
    {
        return $this->termsOfService;
    }

    public function setTermsOfService(?string $termsOfService): self
    {
        $this->termsOfService = $termsOfService;

        return $this;
    }

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function setContact(?string $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    public function getLicence(): ?Licence
    {
        return $this->licence;
    }

    public function setLicence(?Licence $licence): self
    {
        $this->licence = $licence;

        return $this;
    }

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setVersion(?string $version): self
    {
        $this->version = $version;

        return $this;
    }
}
