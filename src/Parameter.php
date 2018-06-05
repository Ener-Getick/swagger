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

final class Parameter extends AbstractObject
{
    use ExtensionPart;

    const
        IN_QUERY = 'query',
        IN_HEADER = 'header',
        IN_PATH = 'path',
        IN_COOKIE = 'cookie';

    /** @var string */
    private $name;

    /** @var string */
    private $in;

    /** @var string|null */
    private $description;

    /** @var bool|null */
    private $required;

    /** @var bool|null */
    private $deprecated;

    /** @var bool|null */
    private $allowEmptyValue;

    /** @var Schema|Reference */
    private $schema;

    /** @var string|null */
    private $style;

    /** @var bool|null */
    private $explode;

    /** @var bool|null */
    private $allowReserved;

    private $content; // TODO:

    private $example; // TODO:

    private $examples; // TODO:

    public function __construct(array $data)
    {
        $this->name = $data['name'];
        $this->in = $data['in'];
        $this->description = $data['description'] ?? null;
        $this->required = $this->in === self::IN_PATH ? true : ($data['required'] ?? null);
        $this->deprecated = $data['deprecated'] ?? null;
        $this->allowEmptyValue = $this->in === self::IN_QUERY ? ($data['allowEmptyValue'] ?? null) : null;
        $this->style = $data['style'] ?? null;
        $this->schema = $data['schema'] ?? null;

        $this->mergeExtensions($data);
    }

    protected function export(): array
    {
        $return = [
            'name' => $this->name,
            'in'   => $this->in,
        ];

        if (null !== $this->description) {
            $return['description'] = $this->description;
        }

        if (!is_null($this->required)) {
            $return['required'] = $this->required;
        }

        if ($this->deprecated === true) {
            $return['deprecated'] = $this->deprecated;
        }

        if ($this->allowEmptyValue) {
            $return['allowEmptyValue'] = $this->allowEmptyValue;
        }

        if (null !== $this->schema) {
            $return['schema'] = $this->schema;
        }

        if (null !== $this->style) {
            $return['style'] = $this->style;
        }

        if ($this->explode) {
            $return['explode'] = $this->explode;
        }

        if ($this->allowReserved) {
            $return['allowReserved'] = $this->allowReserved;
        }

        return $return;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getIn(): string
    {
        return $this->in;
    }

    // TODO: Getters/Setters
}
