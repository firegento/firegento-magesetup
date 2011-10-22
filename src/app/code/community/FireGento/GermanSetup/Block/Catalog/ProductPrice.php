<?php
class FireGento_GermanSetup_Block_Catalog_ProductPrice extends Mage_Catalog_Block_Product_Price
{
    /**
     * Add content of static block below price html if defined in config
     *
     * @return string
     */
    public function _toHtml()
    {
        $html = trim(parent::_toHtml());

        if (empty($html)) {
            return '';
        }

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