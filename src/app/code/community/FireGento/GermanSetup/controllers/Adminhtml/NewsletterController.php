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
 * @since     1.1.4
 */
/**
 * Newsletter Subscriber Status Adminhtml Controller
 *
 * @category  FireGento
 * @package   FireGento_GermanSetup
 * @author    FireGento Team <team@firegento.com>
 * @copyright 2012 FireGento Team (http://www.firegento.de). All rights served.
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License, version 3 (GPLv3)
 * @version   $Id:$
 * @since     1.1.4
 */
class FireGento_GermanSetup_Adminhtml_NewsletterController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Enter description here ...
     *
     * @return void
     */
    public function indexAction()
    {
        $this->_title($this->__('Newsletter'))
            ->_title($this->__('Newsletter Subscribers Status History'));

        if ($this->getRequest()->getParam('ajax')) {
            $this->_forward('grid');

            return;
        }

        $this->loadLayout();

        $this->_setActiveMenu('newsletter/subscriber_status');

        $this->_addBreadcrumb(
            Mage::helper('newsletter')->__('Newsletter'),
            Mage::helper('newsletter')->__('Newsletter')
        );
        $this->_addBreadcrumb(
            Mage::helper('newsletter')->__('Subscribers'),
            Mage::helper('newsletter')->__('Subscribers Status History')
        );

        $this->_addContent(
            $this->getLayout()->createBlock('germansetup/adminhtml_newsletter_subscriber_status', 'subscriber_status')
        );

        $this->renderLayout();
    }

    /**
     * Retrieve the new grid layout via ajax requests
     *
     * @return void
     */
    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('germansetup/adminhtml_newsletter_subscriber_status_grid')->toHtml()
        );
    }
}
