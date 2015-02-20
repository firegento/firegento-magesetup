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
 * Enhanced block for product price display of all products in spite of bundles (got own block!).
 * Contains the normal price.phtml rendering and additionally a configured static block.
 *
 * @category FireGento
 * @package  FireGento_MageSetup
 * @author   FireGento Team <team@firegento.com>
 */
class FireGento_MageSetup_Block_Catalog_Product_Price
    extends FireGento_MageSetup_Block_Catalog_Product_Price_Abstract
{
    /**
     * @var array Path to common tier price template
     */
    protected $_tierPriceDefaultTemplates = array(
        'catalog/product/view/tierprices.phtml',
        'dermodpro/bcp/catalog/product/view/tierprices.phtml'
    );

    /**
     * Add the tierprice default templates
     *
     * @return FireGento_MageSetup_Block_Catalog_Product_Price
     */
    protected function _beforeToHtml()
    {
        $templatesNode = Mage::getConfig()->getNode('magesetup/price/tierprice_default_templates');
        if ($templatesNode) {
            $templates = $templatesNode->asArray();
            foreach ($templates as $template) {
                $this->addTierpriceDefaultTemplate($template);
            }
        }

        return parent::_beforeToHtml();
    }

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

        if (!in_array($this->getTemplate(), $this->_tierPriceDefaultTemplates)) {
            $htmlObject = new Varien_Object();
            $htmlObject->setParentHtml($html);
            $htmlTemplate = $this->getLayout()->createBlock('core/template')
                ->setTemplate('magesetup/price_info.phtml')
                ->setProduct($this->getProduct())
                ->setFormattedTaxRate($this->getFormattedTaxRate())
                ->setIsIncludingTax($this->isIncludingTax())
                ->setIsIncludingShippingCosts($this->isIncludingShippingCosts())
                ->setPriceDisplayType(Mage::helper('tax')->getPriceDisplayType())
                ->setIsShowShippingLink($this->isShowShippingLink())
                ->setIsShowWeightInfo($this->getIsShowWeightInfo())
                ->setFormattedWeight($this->getFormattedWeight())
                ->toHtml();
            $htmlObject->setHtml($htmlTemplate);

            $this->_addDeliveryTimeHtml($htmlObject);

            Mage::dispatchEvent('magesetup_after_product_price',
                array(
                    'html_obj' => $htmlObject,
                    'block'    => $this,
                )
            );

            $html = $htmlObject->getPrefix();
            $html .= $htmlObject->getParentHtml();
            $html .= $htmlObject->getHtml();
            $html .= $htmlObject->getSuffix();
        }

        return $html;
    }

    /**
     * Add delivery time on category pages only
     *
     * @param Varien_Object $htmlObject Transport object
     */
    protected function _addDeliveryTimeHtml($htmlObject)
    {
        if (!Mage::getStoreConfigFlag('catalog/price/display_delivery_time_on_categories')) {
            return;
        }

        $pathInfo = Mage::app()->getRequest()->getPathInfo();
        if (strpos($pathInfo, 'catalog/category/view') !== false
            || strpos($pathInfo, 'catalogsearch/result') !== false
        ) {
            if ($this->getProduct()->getDeliveryTime()) {
                $html = '<p class="delivery-time">';
                $html .= $this->__('Delivery Time') . ': ' . $this->getProduct()->getDeliveryTime();
                $html .= '</p>';
                $htmlObject->setSuffix($html);
            }
        }
    }

    /**
     * Read tax rate from current product.
     *
     * @return string Tax Rate
     */
    public function getTaxRate()
    {
        $taxRateKey = 'tax_rate_' . $this->getProduct()->getId();
        if (!$this->getData($taxRateKey)) {
            $this->setData($taxRateKey, $this->_loadTaxCalculationRate($this->getProduct()));
        }

        return $this->getData($taxRateKey);
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
            $includesTax = Mage::helper('tax')->priceIncludesTax();
            $this->setData('is_including_tax', $includesTax);
        }

        return $this->getData('is_including_tax');
    }

    /**
     * Returns whether or not the price contains taxes
     *
     * @return bool Flag if shipping costs are including taxes
     */
    public function isIncludingShippingCosts()
    {
        if (!$this->getData('is_including_shipping_costs')) {
            $this->setData(
                'is_including_shipping_costs',
                Mage::getStoreConfig('catalog/price/including_shipping_costs')
            );
        }

        return $this->getData('is_including_shipping_costs');
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
                $store = Mage::app()->getStore();
                $groupId = Mage::getSingleton('customer/session')->getCustomerGroupId();
                $group = Mage::getModel('customer/group')->load($groupId);
                $customerTaxClassId = $group->getData('tax_class_id');

                /* @var $calculation Mage_Tax_Model_Calculation */
                $calculation = Mage::getSingleton('tax/calculation');
                $request = $calculation->getRateRequest(null, null, $customerTaxClassId, $store);
                $taxPercent = $calculation->getRate($request->setProductClassId($taxClassId));
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

    /**
     * Add a tierprice default template
     *
     * @param  string $template Template
     * @return FireGento_MageSetup_Block_Catalog_Product_Price
     */
    public function addTierpriceDefaultTemplate($template)
    {
        $this->_tierPriceDefaultTemplates[] = $template;

        return $this;
    }

    /**
     * Translate block sentence
     *
     * @return string Translated text
     */
    public function __()
    {
        $args = func_get_args();
        $expr = new Mage_Core_Model_Translate_Expr(array_shift($args), 'Mage_Catalog');
        array_unshift($args, $expr);

        return Mage::app()->getTranslator()->translate($args);
    }
}
