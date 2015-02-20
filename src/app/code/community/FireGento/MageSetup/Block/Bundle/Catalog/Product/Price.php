<?php
/**
 * This file is part of a FireGento e.V. module.
 *
 * This FireGento e.V. module is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License version 3 as
 * published by the Free Software Foundation.
 *
 * This script is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * PHP version 5
 *
 * @category  FireGento
 * @package   FireGento_MageSetup
 * @author    FireGento Team <team@firegento.com>
 * @copyright 2013-2015 FireGento Team (http://www.firegento.com)
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License, version 3 (GPLv3)
 * @version   2.2.2
 * @since     0.1.0
 */

/**
 * Enhanced block for product price display of bundle products. Contains the normal price.phtml
 * rendering and additionally a configured static block.
 *
 * @category FireGento
 * @package  FireGento_MageSetup
 * @author   FireGento Team <team@firegento.com>
 */
class FireGento_MageSetup_Block_Bundle_Catalog_Product_Price
    extends FireGento_MageSetup_Block_Bundle_Catalog_Product_Price_Abstract
{
    /**
     * Add content of template block below price html if defined in config
     *
     * @return string Price HTML
     */
    public function _toHtml()
    {
        $html = trim(parent::_toHtml());

        if (empty($html) || !Mage::getStoreConfigFlag('catalog/price/display_block_below_price')) {
            return $html;
        }

        $html .= $this->getLayout()->createBlock('core/template')
            ->setTemplate('magesetup/price_info.phtml')
            ->setFormattedTaxRate($this->getFormattedTaxRate())
            ->setIsIncludingTax($this->isIncludingTax())
            ->setIsShowShippingLink($this->isShowShippingLink())
            ->setIsShowWeightInfo($this->getIsShowWeightInfo())
            ->setFormattedWeight($this->getFormattedWeight())
            ->toHtml();

        return $html;
    }

    /**
     * Read tax rate from current product.
     *
     * @return string Tax Rate
     */
    public function getTaxRate()
    {
        if (!$this->getData('tax_rate')) {
            $this->setData('tax_rate', $this->_loadTaxCalculationRate($this->getProduct()));
        }

        return $this->getData('tax_rate');
    }

    /**
     * Retrieves formatted string of tax rate for user output
     *
     * @return string Formatted Tax Rate for the given locale
     */
    public function getFormattedTaxRate()
    {
        if ($this->getTaxRate() === null
            || $this->getProduct()->getTypeId() == 'bundle'
        ) {
            return '';
        }

        $locale = Mage::app()->getLocale()->getLocaleCode();
        $taxRate = Zend_Locale_Format::toFloat($this->getTaxRate(), array('locale' => $locale));

        return $this->__('%s%%', $taxRate);
    }

    /**
     * Returns whether or not the price contains taxes
     *
     * @return bool Flag if prices are shown with including tax
     */
    public function isIncludingTax()
    {
        if (!$this->getData('is_including_tax')) {
            $this->setData('is_including_tax', Mage::getStoreConfig('tax/sales_display/price'));
        }

        return $this->getData('is_including_tax');
    }

    /**
     * Returns whether the shipping link needs to be shown
     * on the frontend or not.
     *
     * @return bool Flag if shipping link should be displayed
     */
    public function isShowShippingLink()
    {
        $productTypeId = $this->getProduct()->getTypeId();
        $ignoreTypeIds = array('virtual', 'downloadable');
        if (in_array($productTypeId, $ignoreTypeIds)) {
            return false;
        }

        return true;
    }

    /**
     * Gets tax percents for current product
     *
     * @param  Mage_Catalog_Model_Product $product Product Model
     * @return string Tax Rate
     */
    protected function _loadTaxCalculationRate(Mage_Catalog_Model_Product $product)
    {
        $taxPercent = $product->getTaxPercent();
        if (is_null($taxPercent)) {
            $taxClassId = $product->getTaxClassId();
            if ($taxClassId) {
                $request = Mage::getSingleton('tax/calculation')->getRateRequest(null, null, null, null);
                $taxPercent = Mage::getSingleton('tax/calculation')->getRate($request->setProductClassId($taxClassId));
            }
        }

        if ($taxPercent) {
            return $taxPercent;
        }

        return 0;
    }

    /**
     * Check if Shipping by Weight is active
     *
     * @return bool Flag if product weight should be displayed
     */
    public function getIsShowWeightInfo()
    {
        return Mage::getStoreConfigFlag('catalog/price/display_product_weight');
    }

    /**
     * Get formatted weight incl. unit
     *
     * @return string Formatted weight
     */
    public function getFormattedWeight()
    {
        return floatval($this->getProduct()->getWeight()) . ' ' . Mage::getStoreConfig('catalog/price/weight_unit');
    }
}
