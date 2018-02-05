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

use EXSyst\Component\Swagger\Parts\ConsumesPart;
use EXSyst\Component\Swagger\Parts\ExtensionPart;
use EXSyst\Component\Swagger\Parts\ExternalDocsPart;
use EXSyst\Component\Swagger\Parts\ParametersPart;
use EXSyst\Component\Swagger\Parts\ProducesPart;
use EXSyst\Component\Swagger\Parts\ResponsesPart;
use EXSyst\Component\Swagger\Parts\SchemesPart;
use EXSyst\Component\Swagger\Parts\SecurityPart;
use EXSyst\Component\Swagger\Parts\TagsPart;
use EXSyst\Component\Swagger\Util\MergeHelper;

final class Operation extends AbstractModel
{
    use ConsumesPart;
    use ProducesPart;
    use TagsPart;
    use ParametersPart;
    use ResponsesPart;
    use SchemesPart;
    use ExternalDocsPart;
    use ExtensionPart;
    use SecurityPart;

    /** @var string */
    private $summary;

    /** @var string */
    private $description;

    /** @var string */
    private $operationId;

    /** @var bool */
    private $deprecated;

    public function __construct($data = [])
    {
        $this->merge($data);
    }

    protected function doMerge($data, $overwrite = false)
    {
        MergeHelper::mergeFields($this->summary, $data['summary'] ?? null, $overwrite);
        MergeHelper::mergeFields($this->description, $data['description'] ?? null, $overwrite);
        MergeHelper::mergeFields($this->operationId, $data['operationId'] ?? null, $overwrite);
        MergeHelper::mergeFields($this->deprecated, $data['deprecated'] ?? null, $overwrite);

        $this->mergeConsumes($data, $overwrite);
        $this->mergeExtensions($data, $overwrite);
        $this->mergeExternalDocs($data, $overwrite);
        $this->mergeParameters($data, $overwrite);
        $this->mergeProduces($data, $overwrite);
        $this->mergeResponses($data, $overwrite);
        $this->mergeSchemes($data, $overwrite);
        $this->mergeSecurity($data, $overwrite);
        $this->mergeTags($data, $overwrite);
    }

    protected function doExport(): array
    {
        return [
            'summary' => $this->getSummary(),
            'description' => $this->getDescription(),
            'operationId' => $this->getOperationId(),
            'deprecated' => $this->getDeprecated(),
            'consumes' => $this->getConsumes() ?: null,
            'produces' => $this->getProduces() ?: null,
            'parameters' => $this->getParameters(),
            'responses' => $this->getResponses(),
            'schemes' => $this->getSchemes() ?: null,
            'tags' => $this->getTags() ?: null,
            'externalDocs' => $this->getExternalDocs(),
            'security' => $this->getSecurity(),
        ];
    }

    /**
     * @return string
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * @param string $summary
     */
    public function setSummary($summary): self
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getOperationId()
    {
        return $this->operationId;
    }

    /**
     * @param string $operationId
     */
    public function setOperationId($operationId): self
    {
        $this->operationId = $operationId;

        return $this;
    }

    /**
     * @return bool
     */
    public function getDeprecated()
    {
        return $this->deprecated;
    }

    /**
     * @param bool $deprecated
     */
    public function setDeprecated($deprecated): self
    {
        $this->deprecated = $deprecated;

        return $this;
    }
}
