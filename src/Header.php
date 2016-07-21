<?php

namespace gossi\swagger;

use gossi\swagger\parts\DescriptionPart;
use gossi\swagger\parts\ExtensionPart;
use gossi\swagger\parts\ItemsPart;
use gossi\swagger\parts\TypePart;
use phootwork\collection\CollectionUtils;
use phootwork\collection\Map;
use phootwork\lang\Arrayable;

class Header extends AbstractModel implements Arrayable
{
    use DescriptionPart;
    use TypePart;
    use ItemsPart;
    use ExtensionPart;

    /** @var string */
    private $header;

    public function __construct($header, $data = [])
    {
        $this->header = $header;
        $this->merge($data);
    }

    protected function parse($contents = [])
    {
        $data = CollectionUtils::toMap($contents);

        // parts
        $this->parseDescription($data);
        $this->parseType($data);
        $this->parseItems($data);
        $this->parseExtensions($data);
    }

    public function toArray()
    {
        return $this->export('description', $this->getTypeExportFields(), 'items');
    }

    /**
     * Returns the header.
     *
     * @return string
     */
    public function getHeader()
    {
        return $this->header;
    }
}
