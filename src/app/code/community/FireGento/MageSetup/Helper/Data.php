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
 * @since     0.1.0
 */

/**
 * Dummy data helper for translation issues.
 *
 * @category FireGento
 * @package  FireGento_MageSetup
 * @author   FireGento Team <team@firegento.com>
 */
class FireGento_MageSetup_Helper_Data extends Mage_Core_Helper_Abstract
{
    // Add support for Magento < 1.7
    const XML_PATH_EU_COUNTRIES_LIST = 'general/country/eu_countries';

    /**
     * Generate URL to configured shipping cost page, or '' if none.
     *
     * @return string Shipping cost url
     */
    public function getShippingCostUrl()
    {
        /** @var $cmsPage Mage_Cms_Model_Page */
        $cmsPage = Mage::getModel('cms/page')
            ->setStoreId(Mage::app()->getStore()->getId())
            ->load(Mage::getStoreConfig('catalog/price/cms_page_shipping'));

        if (!$cmsPage->getId() || !$cmsPage->getIsActive()) {
            return '';
        }

        return Mage::helper('cms/page')->getPageUrl($cmsPage->getId());
    }

    /**
     * Get url of agreement view for checkout
     *
     * @param  Mage_Checkout_Model_Agreement $agreement Agreement
     * @return string URL for the given agreement
     */
    public function getAgreementUrl(Mage_Checkout_Model_Agreement $agreement)
    {
        return Mage::getUrl('magesetup/frontend/agreements', array('id' => $agreement->getId()));
    }

    /**
     * Get available countries
     *
     * @return array All available countries
     */
    public function getAvailableCountries()
    {
        $availableCountries = array();
        $config = Mage::getConfig()->getNode('global/magesetup/available_countries');
        if ($config) {
            foreach (array_keys($config->asArray()) as $countryId) {
                $countryName = Mage::app()->getLocale()->getCountryTranslation(strtoupper($countryId));
                $availableCountries[$countryId] = $countryName;
            }
        }
        asort($availableCountries);

        return $availableCountries;
    }

    /**
     * Check whether specified country is in EU countries list
     *
     * @param  string $countryCode Country Code
     * @return bool Flag if country is an EU country
     */
    public function isCountryInEU($countryCode)
    {
        return in_array(strtoupper($countryCode), $this->getEUCountries());
    }

    /**
     * Get countries in the EU
     *
     * @return array EU Countries
     */
    public function getEUCountries()
    {
        return explode(',', Mage::getStoreConfig(self::XML_PATH_EU_COUNTRIES_LIST));
    }

    /**
     * Set initialization status config flag and refresh config cache.
     *
     * @param bool $isInitialized Flag for initialization
     */
    public function setIsInitialized($isInitialized = true)
    {
        $isInitialized = (bool)$isInitialized ? '1' : '0';
        Mage::getModel('eav/entity_setup', 'core_setup')->setConfigData('magesetup/is_initialized', $isInitialized);
        Mage::app()->getCacheInstance()->cleanType('config');
        Mage::dispatchEvent('adminhtml_cache_refresh_type', array('type' => 'config'));
    }
}
