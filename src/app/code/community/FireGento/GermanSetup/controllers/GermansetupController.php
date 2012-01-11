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
 * Adminhtml Controller for dislaying a form for some actions
 *
 * @category  FireGento
 * @package   FireGento_GermanSetup
 * @author    FireGento Team <team@firegento.com>
 * @copyright 2011 FireGento Team (http://www.firegento.de). All rights served.
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License, version 3 (GPLv3)
 * @version   $Id:$
 * @since     0.4.0
 */
class FireGento_GermanSetup_GermansetupController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Basic action: setup form
     *
     * @return void
     */
    public function indexAction()
    {
        $helper = Mage::helper('germansetup');
        $this->loadLayout()
            ->_setActiveMenu('system/germansetup/setup')
            ->_addBreadcrumb($helper->__('German Setup'), $helper->__('German Setup'))
            ->renderLayout();
    }

    /**
     * Recommended extensions
     *
     * @return void
     */
    public function extensionsAction()
    {
        $helper = Mage::helper('germansetup');
        $this->loadLayout()
            ->_setActiveMenu('system/germansetup/extensions')
            ->_addBreadcrumb($helper->__('German Setup'), $helper->__('German Setup'))
            ->renderLayout();
    }

    /**
     * Basic action: setup save action
     *
     * @return void
     */
    public function saveAction()
    {
        if ($this->getRequest()->isPost()) {
            try {
                if ($this->getRequest()->getParam('cms') == 1) {
                    Mage::getSingleton('germansetup/setup_cms')->setup();
                    $this->_getSession()->addSuccess($this->__('German Setup: CMS Blocks and Pages have been created.'));
                    Mage::log($this->__('German Setup: CMS Blocks and Pages have been created.'));
                }

                if ($this->getRequest()->getParam('agreements') == 1) {
                    Mage::getSingleton('germansetup/setup_agreements')->setup();
                    $this->_getSession()->addSuccess($this->__('German Setup: Checkout Agreements have been created.'));
                    Mage::log($this->__('German Setup: Checkout Agreements have been created.'));
                }

                if ($this->getRequest()->getParam('email') == 1) {
                    Mage::getSingleton('germansetup/setup_email')->setup();
                    $this->_getSession()->addSuccess($this->__('German Setup: Email Templates have been created.'));
                    Mage::log($this->__('German Setup: Email Templates have been created.'));
                }

                if ($this->getRequest()->getParam('tax') == 1) {
                    Mage::getSingleton('germansetup/setup_tax')->setup();
                    $this->_getSession()->addSuccess($this->__('German Setup: Tax Settings have been created.'));
                    Mage::log($this->__('German Setup: Tax Settings have been created.'));
                }

                // Set a config flag to indicate that the setup has been initialized.
                Mage::getModel('eav/entity_setup', 'core_setup')->setConfigData('germansetup/is_initialized', '1');

            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
                Mage::logException($e);
            }

            if ($this->getRequest()->getParam('product_tax_classes') == 1) {
                $this->_updateProductTaxClasses();
                $this->_getSession()->addSuccess($this->__('German Setup: Product Tax Classes have been updated.'));
                Mage::log($this->__('German Setup: Product Tax Classes have been updated.'));
            }
        }
        $this->_redirect('*/*');
    }

    protected function _updateProductTaxClasses()
    {
        $taxClasses = $this->getRequest()->getParam('product_tax_class_target');
        foreach ($taxClasses as $source => $target) {
            if ($target = intval($target)) {

                Mage::getSingleton('germansetup/setup_tax')->updateProductTaxClasses($source, $target);
            }
        }
    }
}
