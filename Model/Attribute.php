<?php


namespace TemplateProvider\Attribute\Model;

use TemplateProvider\Attribute\Api\Data\AttributeInterface;

class Attribute implements AttributeInterface
{
    public string $code;

    public string $value;

    public function getCode(): string
    {
        return $this->code;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
