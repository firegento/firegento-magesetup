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
 * Adminhtml Controller for dislaying a form for some actions
 *
 * @category  FireGento
 * @package   FireGento_GermanSetup
 * @author    FireGento Team <team@firegento.com>
 * @copyright 2012 FireGento Team (http://www.firegento.de). All rights served.
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

        $this->_title($helper->__('System'))
            ->_title($helper->__('German Setup'))
            ->_title($helper->__('Setup'));

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

        $this->_title($helper->__('System'))
            ->_title($helper->__('German Setup'))
            ->_title($helper->__('Recommended Extensions'));

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
            $country = $this->getRequest()->getParam('country');
            Mage::register('setup_country', $country);
            try {
                if ($this->getRequest()->getParam('systemconfig') == 1) {
                    Mage::getSingleton('germansetup/setup_systemconfig')->setup();
                    $this->_getSession()->addSuccess(
                        $this->__('German Setup: System Config Settings have been updated.')
                    );
                }

                if ($this->getRequest()->getParam('cms') == 1) {
                    Mage::getSingleton('germansetup/setup_cms')->setup();
                    $this->_getSession()->addSuccess(
                        $this->__('German Setup: CMS Blocks and Pages have been created.')
                    );
                }

                if ($this->getRequest()->getParam('agreements') == 1) {
                    Mage::getSingleton('germansetup/setup_agreements')->setup();
                    $this->_getSession()->addSuccess(
                        $this->__('German Setup: Checkout Agreements have been created.')
                    );
                }

                if ($this->getRequest()->getParam('email') == 1) {
                    $emailLocale = $this->getRequest()->getParam('email_locale');
                    Mage::getSingleton('germansetup/setup_email')->setup($emailLocale);
                    $this->_getSession()->addSuccess(
                        $this->__('German Setup: Email Templates have been created.')
                    );
                }

                if ($this->getRequest()->getParam('tax') == 1) {
                    Mage::getSingleton('germansetup/setup_tax')->setup();
                    $this->_getSession()->addSuccess(
                        $this->__('German Setup: Tax Settings have been created.')
                    );

                    $this->_updateProductTaxClasses();
                    $this->_getSession()->addSuccess(
                        $this->__('German Setup: Product Tax Classes have been updated.')
                    );
                }

                // Set a config flag to indicate that the setup has been initialized and refresh config cache.
                Mage::getModel('eav/entity_setup', 'core_setup')->setConfigData('germansetup/is_initialized', '1');
                Mage::app()->getCacheInstance()->cleanType('config');
                Mage::dispatchEvent('adminhtml_cache_refresh_type', array('type' => 'config'));
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*');
    }

    /**
     * Update the old product tax classes to the new tax class ids
     *
     * @return void
     */
    protected function _updateProductTaxClasses()
    {
        $taxClasses = $this->getRequest()->getParam('product_tax_class_target');
        foreach ($taxClasses as $source => $target) {
            if ($target = intval($target)) {
                Mage::getSingleton('germansetup/setup_tax')->updateProductTaxClasses($source, $target);
            }
        }

        $this->_markIndicesOutdated();
    }

    /**
     * Mark relevant indices as outdated after chinging tax rates
     *
     * @return void
     */
    protected function _markIndicesOutdated()
    {
        // Indexes which need to be updated after setup
        $indexes = array('catalog_product_price', 'catalog_product_flat', 'catalog_product_attribute');

        $indices = Mage::getModel('index/process')
            ->getCollection()
            ->addFieldToFilter('indexer_code', array('in' => $indexes));

        foreach ($indices as $index) {
            $index->setStatus(Mage_Index_Model_Process::STATUS_REQUIRE_REINDEX)->save();
        }
    }
}
