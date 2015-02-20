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
 * @since     0.4.0
 */

/**
 * Displays a form with some options to setup things
 *
 * @category FireGento
 * @package  FireGento_MageSetup
 * @author   FireGento Team <team@firegento.com>
 */
class FireGento_MageSetup_Block_Adminhtml_Magesetup extends Mage_Adminhtml_Block_Widget
{
    /**
     * Class Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setTitle('MageSetup');
    }

    /**
     * Retrieve the POST URL for the form
     *
     * @return string URL
     */
    public function getPostActionUrl()
    {
        return $this->getUrl('*/*/save');
    }

    /**
     * Get old product tax classes
     *
     * @return array All existing product tax classes
     */
    public function getProductTaxClasses()
    {
        return Mage::getSingleton('magesetup/source_tax_productTaxClass')->getAllOptions();
    }

    /**
     * Get old product tax classes
     *
     * @return array All existing product tax classes
     */
    public function getCustomerTaxClasses()
    {
        return Mage::getSingleton('magesetup/source_tax_customerTaxClass')->getAllOptions();
    }

    /**
     * Get new product tax classes (yet to be created)
     *
     * @return array All new product tax classes
     */
    public function getNewProductTaxClasses()
    {
        return Mage::getSingleton('magesetup/source_tax_newProductTaxClass')->getAllOptions();
    }

    /**
     * Get new product tax classes (yet to be created)
     *
     * @return array All new product tax classes
     */
    public function getNewCustomerTaxClasses()
    {
        return Mage::getSingleton('magesetup/source_tax_newCustomerTaxClass')->getAllOptions();
    }

    /**
     * Retrieve the default default new product tax class (yet to be created)
     *
     * @return int Default Product Tax Class
     */
    public function getDefaultProductTaxClass()
    {
        return Mage::getSingleton('magesetup/source_tax_newProductTaxClass')->getDefaultOption();
    }

    /**
     * Retrieve all locales where the directory email/template exists
     *
     * @return array Locale options for email templates
     */
    public function getLocaleOptionsForEmailTemplates()
    {
        $options = Mage::getSingleton('adminhtml/system_config_source_locale')->toOptionArray();
        foreach ($options as $key => $value) {
            $filePath = Mage::getBaseDir('locale') . DS . $value['value'] . DS . 'template' . DS . 'email';
            if (!file_exists($filePath)) {
                unset($options[$key]);
            }
        }

        return $options;
    }

    /**
     * Retrieve all locales where the directory email/template exists
     *
     * @return array Locale options for CMS content
     */
    public function getLocaleOptionsForCmsContent()
    {
        $options = Mage::getSingleton('adminhtml/system_config_source_locale')->toOptionArray();
        foreach ($options as $key => $value) {
            $filePath = Mage::getBaseDir('locale') . DS . $value['value'] . DS . 'template' . DS . 'magesetup';
            if (!file_exists($filePath)) {
                unset($options[$key]);
            }
        }

        return $options;
    }

    /**
     * Check if there is more than one Store View
     *
     * @return bool Flag if there are more than one store
     */
    public function isMultiStore()
    {
        return (sizeof($this->getStores()) > 1);
    }

    /**
     * Retrieve all stores
     *
     * @return array All stores
     */
    public function getStores()
    {
        return Mage::app()->getStores(false);
    }

    /**
     * Retrieve all available countries for MageSetup
     *
     * @return array All allowed countries
     */
    public function getAvailableCountriesForSetup()
    {
        return Mage::helper('magesetup')->getAvailableCountries();
    }

    /**
     * Retrieve the new product tax classes as JSON
     *
     * @return string JSON with Product Tax Classes
     */
    public function getNewProductTaxClassesJson()
    {
        $moduleDir = Mage::getConfig()->getModuleDir('etc', 'FireGento_MageSetup');

        $countryTaxClasses = array();
        foreach (Mage::helper('magesetup')->getAvailableCountries() as $countryId => $countryName) {
            // Get the config file for the given country
            $configFile = $moduleDir . DS . $countryId . DS . 'tax.xml';

            // If the given file does not exist, use the default file
            if (!file_exists($configFile)) {
                $configFile = $moduleDir . DS . 'default' . DS . 'tax.xml';
            }

            $xml = new SimpleXMLElement(file_get_contents($configFile));

            // @codingStandardsIgnoreStart
            $taxClasses = $xml->default->magesetup->tax_classes->default;
            foreach ($taxClasses->children() as $identifier => $taxClass) {
                if ($taxClass->class_type != 'PRODUCT'
                    || $taxClass->execute != 1
                    || strpos($identifier, 'shipping') === 0
                ) {
                    continue;
                }

                $countryTaxClasses[$countryId][(string)$taxClass->class_id] = (string)$taxClass->class_name;
            }
            // @codingStandardsIgnoreEnd

            $countryTaxClasses[$countryId][] = $this->__('No tax');
        }

        return Zend_Json::encode($countryTaxClasses);
    }

    /**
     * Retrieve the new customer tax classes as JSON
     *
     * @return string JSON with Customer Tax Classes
     */
    public function getNewCustomerTaxClassesJson()
    {
        $moduleDir = Mage::getConfig()->getModuleDir('etc', 'FireGento_MageSetup');

        $countryTaxClasses = array();
        foreach (Mage::helper('magesetup')->getAvailableCountries() as $countryId => $countryName) {
            // Get the config file for the given country
            $configFile = $moduleDir . DS . $countryId . DS . 'tax.xml';

            // If the given file does not exist, use the default file
            if (!file_exists($configFile)) {
                $configFile = $moduleDir . DS . 'default' . DS . 'tax.xml';
            }

            $xml = new SimpleXMLElement(file_get_contents($configFile));

            // @codingStandardsIgnoreStart
            $taxClasses = $xml->default->magesetup->tax_classes->default;
            foreach ($taxClasses->children() as $identifier => $taxClass) {
                if ($taxClass->class_type != 'CUSTOMER'
                    || $taxClass->execute != 1
                ) {
                    continue;
                }
                $countryTaxClasses[$countryId][(string)$taxClass->class_id] = (string)$taxClass->class_name;
            }
            // @codingStandardsIgnoreEnd
        }

        return Zend_Json::encode($countryTaxClasses);
    }
}

