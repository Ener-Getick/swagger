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

    /** @var string */
    private $title;

    /** @var string */
    private $description;

    /** @var string */
    private $termsOfService;

    /** @var Contact */
    private $contact;

    /** @var License */
    private $license;

    /** @var string */
    private $version;

    public function __construct(array $data)
    {
        $this->title = $data['title'];
        $this->description = $data['description'] ?? null;
        $this->termsOfService = $data['termsOfService'] ?? null;
        if (isset($data['contact'])) {
            $this->contact = new Contact($data['contact']);
        }
        if (isset($data['license'])) {
            $this->license = new License($data['license']);
        }
        $this->version = $data['version'];

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
}
