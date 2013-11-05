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
 * @copyright 2013 FireGento Team (http://www.firegento.com)
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License, version 3 (GPLv3)
 * @version   $Id:$
 * @since     0.1.0
 */
/**
 * Block to display agreements on checkout.
 *
 * @category FireGento
 * @package  FireGento_MageSetup
 * @author   FireGento Team <team@firegento.com>
 */
class FireGento_MageSetup_Block_Checkout_Agreements extends Mage_Checkout_Block_Agreements
{
    /**
     * Filter by "Agreement Type"
     *
     * @return Mage_Checkout_Model_Resource_Agreement_Collection Agreements|array
     */
    public function getAgreements()
    {
        if (!$this->hasAgreements()) {
            if (!Mage::getStoreConfigFlag('checkout/options/enable_agreements')) {
                $agreements = array();
            } else {
                $agreements = parent::getAgreements();
                if ($this->_getCustomerSession()->isLoggedIn()) {
                    $agreements->addFieldToFilter('agreement_type', array('in' => array(
                        FireGento_MageSetup_Model_Source_AgreementType::AGREEMENT_TYPE_CHECKOUT,
                        FireGento_MageSetup_Model_Source_AgreementType::AGREEMENT_TYPE_BOTH,
                    )));
                } else {
                    $agreements->addFieldToFilter('agreement_type', array('in' => array(
                        FireGento_MageSetup_Model_Source_AgreementType::AGREEMENT_TYPE_CUSTOMER,
                        FireGento_MageSetup_Model_Source_AgreementType::AGREEMENT_TYPE_CHECKOUT,
                        FireGento_MageSetup_Model_Source_AgreementType::AGREEMENT_TYPE_BOTH,
                    )));
                }
            }
            $this->setAgreements($agreements);
        }
        return $this->getData('agreements');
    }

    /**
     * Retrieve the customer session
     *
     * @return Mage_Customer_Model_Session Customer Session
     */
    protected function _getCustomerSession()
    {
        return Mage::getSingleton('customer/session');
    }
}
