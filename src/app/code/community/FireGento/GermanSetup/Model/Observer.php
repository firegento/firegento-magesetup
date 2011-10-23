<?php

class FireGento_GermanSetup_Model_Observer
{
    public function filterAgreements(Varien_Event_Observer $observer)
    {
        $object = $observer->getEvent()->getObject();
        if ($object instanceof Mage_Checkout_Model_Agreement) {
            Mage::helper('firegento/log')->firelogger($object);
        }
    }
}