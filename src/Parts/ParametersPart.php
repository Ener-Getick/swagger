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

use EXSyst\Component\Swagger\Collections\Parameters;

/**
 * @internal
 */
trait ParametersPart
{
    /** @var Parameters|null */
    private $parameters;

    private function mergeParameters(array $data, bool $overwrite)
    {
        if (isset($data['parameters'])) {
            $this->getParameters()->merge($data['parameters'], $overwrite);
        }
    }

    /**
     * Return parameters.
     */
    public function getParameters(): Parameters
    {
        if (null === $this->parameters) {
            $this->parameters = new Parameters();
        }

        return $this->parameters;
    }
}
