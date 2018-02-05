<?php

/*
 * This file is part of the Swagger package.
 *
 * (c) EXSyst
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EXSyst\Component\Swagger;

use EXSyst\Component\Swagger\Parts\ExtensionPart;
use EXSyst\Component\Swagger\Util\MergeHelper;

final class Contact extends AbstractModel
{
    const REQUIRED = false;

    use ExtensionPart;

    /** @var string */
    private $name;

    /** @var string */
    private $url;

    /** @var string */
    private $email;

    public function __construct($data = [])
    {
        $this->merge($data);
    }

    protected function doMerge($data, $overwrite = false)
    {
        MergeHelper::mergeFields($this->name, $data['name'] ?? null, $overwrite);
        MergeHelper::mergeFields($this->url, $data['url'] ?? null, $overwrite);
        MergeHelper::mergeFields($this->email, $data['email'] ?? null, $overwrite);

        $this->mergeExtensions($data, $overwrite);
    }

    protected function doExport(): array
    {
        return [
            'name' => $this->name,
            'url' => $this->url,
            'email' => $this->email,
        ];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email): self
    {
        $this->email = $email;

        return $this;
    }
}
