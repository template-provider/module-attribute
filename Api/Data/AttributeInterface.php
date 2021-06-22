<?php

declare(strict_types = 1);

namespace TemplateProvider\Attribute\Api\Data;

interface AttributeInterface
{
    /**
     * @return string
     */
    public function getCode(): string;

    /**
     * @return string
     */
    public function getValue(): string;

}
