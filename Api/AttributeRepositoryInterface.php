<?php

declare(strict_types = 1);

namespace TemplateProvider\Attribute\Api;

use TemplateProvider\Attribute\Api\Data\AttributeInterface;

interface AttributeRepositoryInterface
{
    /**
     * @param string $attributeCode
     *
     * @return \TemplateProvider\Attribute\Api\Data\AttributeInterface
     */
    public function get($attributeCode): AttributeInterface;
}
