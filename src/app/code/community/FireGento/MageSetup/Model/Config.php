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
 * Config class
 *
 * @category FireGento
 * @package  FireGento_MageSetup
 * @author   FireGento Team <team@firegento.com>
 */
class FireGento_MageSetup_Model_Config extends Varien_Simplexml_Config
{
    const CACHE_ID = 'magesetup_config';
    const CACHE_TAG = 'magesetup_config';

    /**
     * @var string
     */
    protected $_country;

    /**
     * Sets cache ID and cache tags and loads configuration
     *
     * @param string|Varien_Simplexml_Element $sourceData XML Source Data
     */
    public function __construct($sourceData = null)
    {
        $this->setCacheId(self::CACHE_ID);
        $this->setCacheTags(array(self::CACHE_TAG));
        parent::__construct($sourceData);
        $this->_loadConfig();
    }

    /**
     * Set the current country for the config
     *
     * @param  string $country Country
     * @return FireGento_MageSetup_Model_Config Config Model
     */
    public function setCountry($country)
    {
        $this->_country = $country;

        return $this;
    }

    /**
     * Get the current country for the config
     *
     * @return string
     */
    public function getCountry()
    {
        if (empty($this->_country)) {
            $this->_country = strtolower(Mage::getStoreConfig('general/country/default'));
        }

        return $this->_country;
    }

    /**
     * Merge default config with config from additional xml files
     *
     * @return FireGento_MageSetup_Model_Config Config Model
     */
    protected function _loadConfig()
    {
        if (Mage::app()->useCache(self::CACHE_ID)) {
            if ($this->loadCache()) {
                return $this;
            }
        }

        if (!is_null(Mage::registry('setup_country'))) {
            $this->setCountry(Mage::registry('setup_country'));
        }

        $mergeConfig = Mage::getModel('core/config_base');
        $config = Mage::getConfig();

        // Load additional config files
        if ($config->getNode('global/magesetup/additional_files')) {
            foreach ($config->getNode('global/magesetup/additional_files')->asCanonicalArray() as $file) {
                $this->_addConfigFile($file['filename'], $mergeConfig, (array_key_exists('overwrite', $file) && (bool)$file['overwrite'] === false ? false : true));
            }
        }
        $this->_addConfigFile('cms.xml', $mergeConfig, false);
        $this->_addConfigFile('email.xml', $mergeConfig);
        $this->_addConfigFile('systemconfig.xml', $mergeConfig);
        $this->_addConfigFile('agreement.xml', $mergeConfig);
        $this->_addConfigFile('tax.xml', $mergeConfig);

        $this->setXml($config->getNode());

        if (Mage::app()->useCache(self::CACHE_ID)) {
            $this->saveCache();
        }

        return $this;
    }

    /**
     * Add a config file to the given merge config
     *
     * @param string                      $fileName    File to load
     * @param Mage_Core_Model_Config_Base $mergeConfig Global config for merging
     */
    protected function _addConfigFile($fileName, $mergeConfig, $overwrite = true)
    {
        $config = Mage::getConfig();
        $configFile = $config->getModuleDir('etc', 'FireGento_MageSetup') . DS . $this->getCountry() . DS . $fileName;

        // If the given file does not exist, use the default file
        if (!file_exists($configFile)) {
            $configFile = $config->getModuleDir('etc', 'FireGento_MageSetup') . DS . 'default' . DS . $fileName;
        }

        // Load the given config file
        if (file_exists($configFile)) {
            if ($mergeConfig->loadFile($configFile)) {
                $config->extend($mergeConfig, $overwrite);
            }
        }
    }
}
