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
 * Block to enable ip anonymization for german tracking.
 *
 * @category  FireGento
 * @package   FireGento_GermanSetup
 * @author    FireGento Team <team@firegento.com>
 * @copyright 2012 FireGento Team (http://www.firegento.de). All rights served.
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License, version 3 (GPLv3)
 * @version   $Id:$
 * @since     0.1.0
 */
class FireGento_GermanSetup_Block_Checkout_Information extends Mage_Core_Block_Template
{
    /**
     * @var string
     */
    const XML_PATH_CHECKOUT_DISPLAY_ADDITIONAL_INFORMATION = 'checkout/options/display_additional_information';

    /**
     * @var string
     */
    const XML_PATH_CHECKOUT_ADDITIONAL_INFORMATION = 'checkout/options/additional_information';

    /**
     * Retrieve the additional information for the review page
     *
     * @return string|boolean
     */
    public function getCheckoutAdditionalInformation()
    {
        $additional = '';

        if (Mage::getStoreConfigFlag(self::XML_PATH_CHECKOUT_DISPLAY_ADDITIONAL_INFORMATION)) {
            $additional = trim(Mage::getStoreConfig(self::XML_PATH_CHECKOUT_ADDITIONAL_INFORMATION));
        }

        // Dispatch Event in order to allow adding more additional information texts
        $additionalObject = new Varien_Object(array('text' => $additional));
        Mage::dispatchEvent('checkout_additional_information', array('additional' => $additionalObject));
        $additional = $additionalObject->getText();

        if (!$additional) {
            return false;
        }

        return $additional;
    }
}
