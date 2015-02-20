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
 * @since     1.1.4
 */

/**
 * Observer class
 *
 * @category FireGento
 * @package  FireGento_MageSetup
 * @author   FireGento Team <team@firegento.com>
 */
class FireGento_MageSetup_Model_Newsletter_Observer
{
    /**
     * Saves the subscriber status change in a custom history
     * after a subscriber was saved.
     *
     * Event: <newsletter_subscriber_save_after>
     *
     * @param Varien_Event_Observer $observer Observer
     */
    public function saveSubscriberStatusHistory(Varien_Event_Observer $observer)
    {
        try {
            /* @var $subscriber Mage_Newsletter_Model_Subscriber */
            $subscriber = $observer->getEvent()->getSubscriber();

            /* @var $status FireGento_MageSetup_Model_Newsletter_Subscriber_Status */
            $status = Mage::getModel('magesetup/newsletter_subscriber_status');
            $status->setData('subscriber', $subscriber->getId());
            $status->setData('status', $subscriber->getData('subscriber_status'));
            $status->setData('email', $subscriber->getData('subscriber_email'));
            $status->setData('created_at', now());
            $status->save();
        } catch (Exception $e) {
            Mage::logException($e);
        }
    }
}
