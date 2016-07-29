<?php

/*
 * This file is part of the Swagger package.
 *
 * (c) EXSyst
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EXSyst\Swagger;

use EXSyst\Swagger\Parts\DescriptionPart;
use EXSyst\Swagger\Parts\ExtensionPart;
use EXSyst\Swagger\Util\MergeHelper;

final class Info extends AbstractModel
{
    const REQUIRED = false;

    use DescriptionPart;
    use ExtensionPart;

    /** @var string */
    private $title;

    /** @var string */
    private $termsOfService;

    /** @var Contact */
    private $contact;

    /** @var License */
    private $license;

    /** @var string */
    private $version;

    public function __construct($data = [])
    {
        $this->contact = new Contact();
        $this->license = new License();

        $this->merge($data);
    }

    protected function doMerge($data, $overwrite = false)
    {
        MergeHelper::mergeFields($this->title, $data['title'] ?? null, $overwrite);
        MergeHelper::mergeFields($this->termsOfService, $data['termsOfService'] ?? null, $overwrite);
        MergeHelper::mergeFields($this->version, $data['version'] ?? null, $overwrite);

        $this->contact->merge($data['contact'] ?? [], $overwrite);
        $this->license->merge($data['license'] ?? [], $overwrite);

        $this->mergeDescription($data, $overwrite);
        $this->mergeExtensions($data, $overwrite);
    }

    protected function doExport()
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'termsOfService' => $this->termsOfService,
            'contact' => $this->contact,
            'license' => $this->license,
            'version' => $this->version,
        ];
    }

    /**
     * @return string|null
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTerms()
    {
        return $this->termsOfService;
    }

    /**
     * @param string|null $terms
     */
    public function setTerms($terms)
    {
        $this->termsOfService = $terms;

        return $this;
    }

    /**
     * @return Contact
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * @return License
     */
    public function getLicense()
    {
        return $this->license;
    }

    /**
     * @return string|null
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param string|null $version
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }
}
