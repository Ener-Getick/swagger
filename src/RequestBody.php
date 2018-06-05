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

use EXSyst\OAS\Collections\Content;

final class RequestBody extends AbstractObject
{
    use ExtensionPart;

    /** @var string|null */
    private $description;

    /** @var Content */
    private $content;

    /** @var bool */
    private $required;

    public function __construct(array $data)
    {
        $this->description = $data['description'] ?? null;
        $this->content = new Content($data['content'] ?? []);
        $this->required = $data['required'] ?? false;

        $this->mergeExtensions($data);
    }

    protected function export(): array
    {
        $return = [
            'content' => $this->content,
        ];

        if (null !== $this->description) {
            $return['description'] = $this->description;
        }

        if ($this->required) {
            $return['required'] = $this->required;
        }

        return $return;
    }
}
