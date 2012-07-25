<?php
/**
 * This file is part of the FIREGENTO project.
 *
 * FireGento_GermanSetup is free software; you can redistribute it and/or
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
 * @package   FireGento_GermanSetup
 * @author    FireGento Team <team@firegento.com>
 * @copyright 2012 FireGento Team (http://www.firegento.de). All rights served.
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License, version 3 (GPLv3)
 * @version   $Id:$
 * @since     0.1.0
 */
/**
 * Tax config model with new shipping tax class calculation
 *
 * @category  FireGento
 * @package   FireGento_GermanSetup
 * @author    FireGento Team <team@firegento.com>
 * @copyright 2012 FireGento Team (http://www.firegento.de). All rights served.
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License, version 3 (GPLv3)
 * @version   $Id:$
 * @since     0.6.2
 */
class FireGento_GermanSetup_Model_Tax_Config extends Mage_Tax_Model_Config
{
    const XML_PATH_SHIPPING_TAX_ON_PRODUCT_TAX = 'tax/classes/shipping_tax_on_product_tax';

    /**
     * Get tax class id specified for shipping tax estimation based on highest product
     * tax rate of the products in the current customer quote.
     *
     * @param Mage_Core_Model_Store $store
     * @return int
     */
    public function getShippingTaxClass($store=null)
    {
        /* @var $session Mage_Checkout_Model_Session */
        $session = Mage::getSingleton('checkout/session');

        $quoteItems = $session->getQuote()->getAllItems();
        $taxClassIds = array();
        $highestTaxRate = null;

        // Check if feature is enabled and if there are products in cart
        if (!Mage::getStoreConfigFlag(self::XML_PATH_SHIPPING_TAX_ON_PRODUCT_TAX, $store)
            || count($quoteItems) == 0
        ) {
            $taxClassId = (int) Mage::getStoreConfig(self::CONFIG_XML_PATH_SHIPPING_TAX_CLASS, $store);
            return $taxClassId;
        }

        // Fetch the tax rates from the quote items
        foreach ($quoteItems as $item) {

            /** @var $item Mage_Sales_Model_Quote_Item */
            if ($item->getParentItem()) {
                continue;
            }

            $taxPercent = $this->_loadTaxCalculationRate($item);
            if (is_float($taxPercent) && !in_array($taxPercent, $taxClassIds)) {
                $taxClassIds[$taxPercent] = $item->getTaxClassId();
            }
        }

        // Get the highest tax rate
        ksort($taxClassIds);
        if (count($taxClassIds)) {
            $highestTaxRate = array_pop($taxClassIds);
        }

        if (!$highestTaxRate || is_null($highestTaxRate)) {
            $taxClassId = 0;
        } else {
            $taxClassId = $highestTaxRate;
        }

        return (int) $taxClassId;
    }

    /**
     * Gets tax percents for current sales quote item
     *
     * @param Mage_Sales_Model_Quote_Item $item
     * @return string
     */
    protected function _loadTaxCalculationRate(Mage_Sales_Model_Quote_Item $item)
    {
        $taxPercent = $item->getTaxPercent();
        if (is_null($taxPercent)) {
            $taxClassId = $item->getTaxClassId();
            if ($taxClassId) {
                $request    = Mage::getSingleton('tax/calculation')->getRateRequest(null, null, null, null);
                $taxPercent = Mage::getSingleton('tax/calculation')->getRate($request->setProductClassId($taxClassId));
            }
        }

        if ($taxPercent) {
            return $taxPercent;
        }
        return 0;
    }
}
