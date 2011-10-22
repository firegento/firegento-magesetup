<?php
class FireGento_GermanSetup_Block_Bundle_CatalogProductPrice extends Mage_Bundle_Block_Catalog_Product_Price
{
    /**
     * Add content of static block below price html if defined in config
     *
     * @return string
     */
    public function _toHtml()
    {
        $html = parent::_toHtml();

        $blockIdentifier = Mage::getStoreConfig('catalog/price/block_below_price');

        if ($blockIdentifier) {
            $blockModel = Mage::getModel('cms/block')
                ->setStoreId(Mage::app()->getStore()->getId())
                ->load($blockIdentifier);

            if ($blockModel->getId() && $blockModel->getIsActive()) {
                $html .= $this->getLayout()->createBlock('cms/block')->setBlockId($blockModel->getId())->toHtml();
            }

        }
        return $html;
    }
}