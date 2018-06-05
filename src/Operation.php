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

use EXSyst\OAS\Collections\Callbacks;
use EXSyst\OAS\Collections\Parameters;

final class Operation extends AbstractObject
{
    use ExtensionPart;

    /** @var string[] */
    private $tags;

    /** @var string */
    private $summary;

    /** @var string */
    private $description;

    /** @var string */
    private $operationId;

    /** @var Parameters */
    private $parameters;

    /** @var RequestBody|Reference */
    private $requestBody;

    /** @var Responses */
    private $responses;

    /** @var Callbacks */
    private $callbacks;

    /** @var bool */
    private $deprecated;

    /** @var SecurityRequirement */
    private $security; // TODO

    /** @var Server[] */
    private $servers; // TODO

    public function __construct(array $data = [])
    {
        $this->tags = $data['tags'] ?? [];
        $this->summary = $data['summary'] ?? null;
        $this->description = $data['description'] ?? null;
        $this->operationId = $data['operationId'] ?? null;
        $this->parameters = new Parameters($data['parameters'] ?? []);
        $this->requestBody = referenceOr(RequestBody::class, $data['requestBody'] ?? []);
        $this->responses = new Responses($data['responses'] ?? []);
        $this->deprecated = $data['deprecated'] ?? false;
        $this->callbacks = new Callbacks($data['callbacks'] ?? []);

        $this->mergeExtensions($data);
    }

    protected function export(): array
    {
        $return = [];

        if (count($this->tags) !== 0) {
            $return['tags'] = $this->tags;
        }

        if (null !== $this->summary) {
            $return['summary'] = $this->summary;
        }

        if (null !== $this->description) {
            $return['description'] = $this->description;
        }

        if (null !== $this->operationId) {
            $return['operationId'] = $this->operationId;
        }

        if (!$this->parameters->isEmpty()) {
            $return['parameters'] = $this->parameters;
        }

        if (null !== $this->requestBody) {
            $return['requestBody'] = $this->requestBody;
        }

        if (!$this->responses->isEmpty()) {
            $return['responses'] = $this->responses;
        }

        if (!$this->callbacks->isEmpty()) {
            $return['callbacks'] = $this->callbacks;
        }

        if ($this->deprecated === true) {
            $return['deprecated'] = $this->deprecated;
        }

        return $return;
    }
}
