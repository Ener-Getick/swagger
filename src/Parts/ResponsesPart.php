<?php

/*
 * This file is part of the Swagger package.
 *
 * (c) EXSyst
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EXSyst\Component\Swagger\Parts;

use EXSyst\Component\Swagger\Collections\Responses;

/**
 * @internal
 */
trait ResponsesPart
{
    /** @var Responses|null */
    private $responses;

    private function mergeResponses(array $data, bool $overwrite)
    {
        if (isset($data['responses'])) {
            $this->getResponses()->merge($data['responses'], $overwrite);
        }
    }

    /**
     * Return responses.
     */
    public function getResponses(): Responses
    {
        if (null === $this->responses) {
            $this->responses = new Responses();
        }

        return $this->responses;
    }
}
