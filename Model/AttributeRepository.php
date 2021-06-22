<?php

declare(strict_types = 1);

namespace TemplateProvider\Attribute\Model;

use Magento\Framework\Exception\NoSuchEntityException;
use TemplateProvider\Attribute\Api\AttributeRepositoryInterface;
use TemplateProvider\Attribute\Api\Data\AttributeInterface;

class AttributeRepository implements AttributeRepositoryInterface
{
    /**
     * @var \Magento\Eav\Model\Config
     */
    protected $eavConfig;

    protected \Magento\Store\Model\StoreManagerInterface $storeManagerInterface;

    /**
     * @param \Magento\Eav\Model\Config $eavConfig
     * @codeCoverageIgnore
     */
    public function __construct(
        \Magento\Eav\Model\Config $eavConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManagerInterface
    ) {
        $this->eavConfig = $eavConfig;
        $this->storeManagerInterface = $storeManagerInterface;
    }

    public function get($attributeCode): AttributeInterface
    {
        /** @var \Magento\Eav\Api\Data\AttributeInterface $magentoAttribute */
        $magentoAttribute = $this->eavConfig->getAttribute( \Magento\Catalog\Model\Product::ENTITY, $attributeCode);
        if (!$magentoAttribute || !$magentoAttribute->getAttributeId()) {
            throw new NoSuchEntityException(
                __(
                    'The attribute with a "%1" attributeCode doesn\'t exist. Verify the attribute and try again.',
                    $attributeCode
                )
            );
        }
        if ($magentoAttribute->getFrontendInput() !== 'select') {
            throw new \Exception( (string) __('The attribute code is not an input type, only select input types are provided'));
        }

        $storeId = $this->storeManagerInterface->getStore()->getId();
        $options = $magentoAttribute->getSource()->getAllOptions();

        /** @var \Magento\Eav\Api\Data\AttributeInterface $magentoAdminAttribute */
        $magentoAdminAttribute = $this->eavConfig->getAttribute( \Magento\Catalog\Model\Product::ENTITY, $attributeCode)->setStoreId(0);

        /** Todo: move to attributefactory */
        $attribute = new Attribute();
        $attribute->code = $magentoAdminAttribute->getSource()->getOptionText($magentoAdminAttribute->getDefaultValue());
        $attribute->value = (string) $options[$storeId]['label'];

        return $attribute;
    }
}
