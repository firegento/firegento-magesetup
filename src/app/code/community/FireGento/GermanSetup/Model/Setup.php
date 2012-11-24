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
 * @since     0.2.0
 */
/**
 * Setup class
 *
 * @category  FireGento
 * @package   FireGento_GermanSetup
 * @author    FireGento Team <team@firegento.com>
 * @copyright 2012 FireGento Team (http://www.firegento.de). All rights served.
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License, version 3 (GPLv3)
 * @version   $Id:$
 * @since     1.2.0
 */
class FireGento_GermanSetup_Model_Setup extends Mage_Core_Model_Abstract
{
    /**
     * Setup GermanSetup as if a user sends the adminhtml form
     * See method _getDefaultParams for possible params
     *
     * @param array $params
     * @return FireGento_GermanSetup_Model_Setup
     */
    public function setup($params = array())
    {
        $defaultParams = $this->_getDefaultParams();

        $params = array_merge($defaultParams, $params);

        Mage::register('setup_country', $params['country']);

        if ($params['systemconfig']) {
            Mage::getSingleton('germansetup/setup_systemconfig')->setup();
        }

        if ($params['cms']) {
            Mage::getSingleton('germansetup/setup_cms')->setup();
        }

        if ($params['agreements']) {
            Mage::getSingleton('germansetup/setup_agreements')->setup();
        }

        if ($params['email']) {
            Mage::getSingleton('germansetup/setup_email')->setup($params['email_locale'], $params['overwrite_emails']);
        }

        if ($params['tax']) {
            Mage::getSingleton('germansetup/setup_tax')->setup();

            $this->_updateProductTaxClasses($params);
        }

        // Set a config flag to indicate that the setup has been initialized and refresh config cache.
        Mage::getModel('eav/entity_setup', 'core_setup')->setConfigData('germansetup/is_initialized', '1');
        Mage::app()->getCacheInstance()->cleanType('config');
        Mage::dispatchEvent('adminhtml_cache_refresh_type', array('type' => 'config'));

        return $this;
    }

    /**
     * Get default parameters like they are in the backend form
     *
     * @return array
     */
    protected function _getDefaultParams()
    {
        $productTaxClassTargets = array();
        foreach(Mage::getSingleton('germansetup/source_tax_productTaxClass')->getAllOptions() as $option) {
            $productTaxClassTargets[$option['value']] = 1;
        }

        return array(
            'country'                   => 'de',
            'systemconfig'              => true,
            'cms'                       => true,
            'agreements'                => true,
            'email'                     => true,
            'email_locale'              => 'de_DE',
            'overwrite_emails'          => false,
            'tax'                       => true,
            'product_tax_class_target'  => $productTaxClassTargets,
        );
    }

    /**
     * Update the old product tax classes to the new tax class ids
     *
     * @param array $params
     * @return void
     */
    protected function _updateProductTaxClasses($params)
    {
        $taxClasses = $params['product_tax_class_target'];
        foreach ($taxClasses as $source => $target) {
            if ($target = intval($target)) {
                Mage::getSingleton('germansetup/setup_tax')->updateProductTaxClasses($source, $target);
            }
        }

        $this->_markIndicesOutdated();
    }

    /**
     * Mark relevant indices as outdated after changing tax rates
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
