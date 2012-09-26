<?php

class FireGento_GermanSetup_Helper_Checkout_Data
extends Mage_Checkout_Helper_Data
{
    /**
     * get all Required Agreement Ids
     *
     * @return array Agreement Ids
    **/
    public function getRequiredAgreementIds()
    {
        if (is_null($this->_agreements)) {
            if (!Mage::getStoreConfigFlag('checkout/options/enable_agreements')) {
                $this->_agreements = array();
            } else {
                $this->_agreements = Mage::getModel('checkout/agreement')->getCollection()
                    ->addStoreFilter(Mage::app()->getStore()->getId())
                    ->addFieldToFilter('is_active', 1)
                    ->addFieldToFilter('is_required', 1) // Only get Required Elements
                    ->getAllIds();
            }
        }
        return $this->_agreements;
    }
}