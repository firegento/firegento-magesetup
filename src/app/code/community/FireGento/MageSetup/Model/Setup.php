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
 * @since     0.2.0
 */

/**
 * Setup class
 *
 * @category FireGento
 * @package  FireGento_MageSetup
 * @author   FireGento Team <team@firegento.com>
 */
class FireGento_MageSetup_Model_Setup extends Mage_Core_Model_Abstract
{
    /**
     * Setup MageSetup as if a user sends the adminhtml form
     * See method _getDefaultParams for possible params
     *
     * @param  array $params Setup params
     * @param  bool  $notify Flag if admin notifications should be added
     * @return FireGento_MageSetup_Model_Setup Setup Model
     */
    public function setup($params = array(), $notify = false)
    {
        if (!isset($params['country'])) {
            Mage::throwException(
                $this->_getHelper()->__('MageSetup: Please set up a country in your parameters.')
            );
        }

        Mage::register('setup_country', $params['country']);

        $defaultParams = $this->_getDefaultParams();

        $params = array_merge($defaultParams, $params);

        if ($params['systemconfig']) {
            Mage::getSingleton('magesetup/setup_systemconfig')->setup();

            if ($notify) {
                $this->_getAdminhtmlSession()->addSuccess(
                    $this->_getHelper()->__('MageSetup: System Config Settings have been updated.')
                );
            }
        }

        if ($params['cms']) {
            if (!is_array($params['cms_locale'])) {
                $params['cms_locale'] = array('default' => $params['cms_locale']);
            }
            Mage::getSingleton('magesetup/setup_cms')->setup($params['cms_locale']);

            if ($notify) {
                $this->_getAdminhtmlSession()->addSuccess(
                    $this->_getHelper()->__('MageSetup: CMS Blocks and Pages have been created.')
                );
            }
        }

        if ($params['agreements']) {
            if (!is_array($params['cms_locale'])) {
                $params['cms_locale'] = array('default' => $params['cms_locale']);
            }
            Mage::getSingleton('magesetup/setup_agreements')->setup($params['cms_locale']);

            if ($notify) {
                $this->_getAdminhtmlSession()->addSuccess(
                    $this->_getHelper()->__('MageSetup: Checkout Agreements have been created.')
                );
            }
        }

        if ($params['email']) {
            if (!is_array($params['email_locale'])) {
                $params['email_locale'] = array('default' => $params['email_locale']);
            }
            Mage::getSingleton('magesetup/setup_email')->setup($params['email_locale'], $params['overwrite_emails']);

            if ($notify) {
                $this->_getAdminhtmlSession()->addSuccess(
                    $this->_getHelper()->__('MageSetup: Email Templates have been created.')
                );
            }
        }

        if ($params['tax']) {
            // Setup tax settings (rules, classes, ..)
            Mage::getSingleton('magesetup/setup_tax')->setup();
            if ($notify) {
                $this->_getAdminhtmlSession()->addSuccess(
                    $this->_getHelper()->__('MageSetup: Tax Settings have been created.')
                );
            }

            // Update product tax classes
            $this->_updateProductTaxClasses($params);
            if ($notify) {
                $this->_getAdminhtmlSession()->addSuccess(
                    $this->_getHelper()->__('MageSetup: Product Tax Classes have been updated.')
                );
            }

            // Update customer tax classes
            $this->_updateCustomerTaxClasses($params);
            if ($notify) {
                $this->_getAdminhtmlSession()->addSuccess(
                    $this->_getHelper()->__('MageSetup: Customer Tax Classes have been updated.')
                );
            }
        }

        // Set a config flag to indicate that the setup has been initialized and refresh config cache.
        $this->_getHelper()->setIsInitialized();

        return $this;
    }

    /**
     * Get default parameters like they are in the backend form
     *
     * @return array Default setup params
     */
    protected function _getDefaultParams()
    {
        $productTaxClassTargets = array();
        foreach (Mage::getSingleton('magesetup/source_tax_productTaxClass')->getAllOptions() as $option) {
            $value = Mage::getSingleton('magesetup/source_tax_newProductTaxClass')->getDefaultOption();
            $productTaxClassTargets[$option['value']] = $value;
        }

        $customerTaxClassTargets = array();
        foreach (Mage::getSingleton('magesetup/source_tax_customerTaxClass')->getAllOptions() as $option) {
            $value = Mage::getSingleton('magesetup/source_tax_newCustomerTaxClass')->getDefaultOption();
            $customerTaxClassTargets[$option['value']] = $value;
        }

        return array(
            'country'                   => 'de',
            'systemconfig'              => true,
            'cms'                       => true,
            'cms_locale'                => array('default' => 'de_DE'),
            'agreements'                => true,
            'email'                     => true,
            'email_locale'              => array('default' => 'de_DE'),
            'overwrite_emails'          => false,
            'tax'                       => true,
            'product_tax_class_target'  => $productTaxClassTargets,
            'customer_tax_class_target' => $customerTaxClassTargets,
        );
    }

    /**
     * Update the old product tax classes to the new tax class ids
     *
     * @param array $params Setup params
     */
    protected function _updateProductTaxClasses($params)
    {
        $taxClasses = $params['product_tax_class_target'];
        foreach ($taxClasses as $source => $target) {
            if ($target = intval($target)) {
                Mage::getSingleton('magesetup/setup_tax')->updateProductTaxClasses($source, $target);
            }
        }

        $this->_markIndicesOutdated();
    }

    /**
     * Update the old product tax classes to the new tax class ids
     *
     * @param array $params Setup params
     */
    protected function _updateCustomerTaxClasses($params)
    {
        $taxClasses = $params['customer_tax_class_target'];
        foreach ($taxClasses as $source => $target) {
            if ($target = intval($target)) {
                Mage::getSingleton('magesetup/setup_tax')->updateCustomerTaxClasses($source, $target);
            }
        }
    }

    /**
     * Mark relevant indices as outdated after changing tax rates
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

    /**
     * Retrieve the helper class
     *
     * @return FireGento_MageSetup_Helper_Data Helper Class
     */
    protected function _getHelper()
    {
        return Mage::helper('magesetup');
    }

    /**
     * Retrieve the adminhtml session for setup notifications
     *
     * @return Mage_Adminhtml_Model_Session Admin Session
     */
    protected function _getAdminhtmlSession()
    {
        return Mage::getSingleton('adminhtml/session');
    }
}
