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

use EXSyst\Component\Swagger\Collections\Definitions;
use EXSyst\Component\Swagger\Collections\Paths;
use EXSyst\Component\Swagger\Parts\ConsumesPart;
use EXSyst\Component\Swagger\Parts\ExtensionPart;
use EXSyst\Component\Swagger\Parts\ExternalDocsPart;
use EXSyst\Component\Swagger\Parts\ProducesPart;
use EXSyst\Component\Swagger\Parts\ResponsesPart;
use EXSyst\Component\Swagger\Parts\SchemesPart;
use EXSyst\Component\Swagger\Parts\SecurityPart;
use EXSyst\Component\Swagger\Parts\TagsPart;
use EXSyst\Component\Swagger\Util\MergeHelper;

final class Swagger extends AbstractModel
{
    use SchemesPart;
    use ConsumesPart;
    use ProducesPart;
    use TagsPart;
    use ResponsesPart;
    use ExternalDocsPart;
    use ExtensionPart;
    use SecurityPart;

    public static $METHODS = ['get', 'post', 'put', 'patch', 'delete', 'options', 'head'];

    /** @var Info */
    private $info;

    /** @var string */
    private $host;

    /** @var string */
    private $basePath;

    /** @var Paths */
    private $paths;

    /** @var Definitions */
    private $definitions;

    /** @var array */
    private $parameters;

    /** @var array */
    private $securityDefinitions = [];

    /**
     * @param string $filename
     *
     * @return static
     */
    public static function fromFile(string $filename): self
    {
        return new static(json_decode(file_get_contents($filename), true));
    }

    public function __construct($data = [])
    {
        $this->info = new Info();
        $this->definitions = new Definitions();
        $this->paths = new Paths();

        $this->merge($data);
    }

    protected function doMerge($data, $overwrite = false)
    {
        MergeHelper::mergeFields($this->host, $data['host'] ?? null, $overwrite);
        MergeHelper::mergeFields($this->basePath, $data['basePath'] ?? null, $overwrite);

        if (isset($data['info'])) {
            $this->info->merge($data['info'], $overwrite);
        }
        if (isset($data['definitions'])) {
            $this->getDefinitions()->merge($data['definitions'], $overwrite);
        }
        if (isset($data['paths'])) {
            $this->getPaths()->merge($data['paths'], $overwrite);
        }

        $this->mergeConsumes($data, $overwrite);
        $this->mergeExtensions($data, $overwrite);
        $this->mergeExternalDocs($data, $overwrite);
        $this->mergeProduces($data, $overwrite);
        $this->mergeResponses($data, $overwrite);
        $this->mergeSchemes($data, $overwrite);
        $this->mergeSecurity($data, $overwrite);
        $this->mergeTags($data, $overwrite);

        foreach ($data['parameters'] ?? [] as $name => $def) {
            $this->parameters[$name] = new Parameter($def);
        }

        foreach ($data['securityDefinitions'] ?? [] as $name => $def) {
            $this->securityDefinitions[$name] = new SecurityScheme($def);
        }
    }

    protected function doExport(): array
    {
        return [
            'swagger' => '2.0',
            'info' => $this->info,
            'host' => $this->host,
            'basePath' => $this->basePath,
            'schemes' => $this->getSchemes() ?: null,
            'consumes' => $this->getConsumes() ?: null,
            'produces' => $this->getProduces() ?: null,
            'paths' => $this->paths,
            'definitions' => $this->definitions,
            'parameters' => $this->parameters ?: null,
            'responses' => $this->responses,
            'tags' => $this->getTags() ?: null,
            'externalDocs' => $this->externalDocs,
            'securityDefinitions' => $this->securityDefinitions ?: null,
            'security' => $this->getSecurity(),
        ];
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return '2.0';
    }

    /**
     * @return Info
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param string $host
     */
    public function setHost($host): self
    {
        $this->host = $host;

        return $this;
    }

    /**
     * @return string
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * @param string $basePath
     *
     * @return $this
     */
    public function setBasePath($basePath)
    {
        $this->basePath = $basePath;

        return $this;
    }

    /**
     * @return Paths
     */
    public function getPaths()
    {
        return $this->paths;
    }

    /**
     * @return Definitions
     */
    public function getDefinitions()
    {
        return $this->definitions;
    }

    /**
     * @return array
     */
    public function getSecurityDefinitions()
    {
        return $this->securityDefinitions;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param array $parameters
     */
    public function setParameters(array $parameters): self
    {
        $this->parameters = $parameters;

        return $this;
    }
}
