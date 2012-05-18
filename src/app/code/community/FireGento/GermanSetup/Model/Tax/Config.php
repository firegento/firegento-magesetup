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
 * @copyright 2011 FireGento Team (http://www.firegento.de). All rights served.
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
 * @copyright 2011 FireGento Team (http://www.firegento.de). All rights served.
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License, version 3 (GPLv3)
 * @version   $Id:$
 * @since     0.6.2
 */
class FireGento_GermanSetup_Model_Tax_Config extends Mage_Tax_Model_Config
{
    const XML_PATH_SHIPPING_TAX_ON_PRODUCT_TAX = 'tax/classes/shipping_tax_on_product_tax';

    /**
     * Get tax class id specified for shipping tax estimation
     *
     * CUSTOM: Select shipping tax class based on highest product tax rate
     *
     * @param   store $store
     * @return  int
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


        foreach ($quoteItems as $item) {
            if ($item->getParentItem()) {
                continue;
            }

            $taxPercent = $item->getTaxPercent();
            if (is_float($taxPercent) && !in_array($taxPercent, $taxClassIds)) {
                $taxClassIds[$taxPercent] = $item->getTaxClassId();
            }
        }

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
}