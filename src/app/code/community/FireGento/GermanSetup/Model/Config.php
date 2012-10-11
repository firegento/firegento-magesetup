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
 * Config class
 *
 * @category  FireGento
 * @package   FireGento_GermanSetup
 * @author    FireGento Team <team@firegento.com>
 * @copyright 2012 FireGento Team (http://www.firegento.de). All rights served.
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License, version 3 (GPLv3)
 * @version   $Id:$
 * @since     0.2.0
 */
class FireGento_GermanSetup_Model_Config extends Varien_Simplexml_Config
{
    const CACHE_ID  = 'germansetup_config';
    const CACHE_TAG = 'germansetup_config';

    /**
     * Sets cache ID and cache tags and loads configuration
     *
     * @param  string|Varien_Simplexml_Element $sourceData
     * @return void
     */
    public function __construct($sourceData=null)
    {
        $this->setCacheId(self::CACHE_ID);
        $this->setCacheTags(array(self::CACHE_TAG));
        parent::__construct($sourceData);
        $this->_loadConfig();
    }

    /**
     * Merge default config with config from additional xml files
     *
     * @return FireGento_GermanSetup_Model_Config
     */
    protected function _loadConfig()
    {
        if (Mage::app()->useCache(self::CACHE_ID)) {
            if ($this->loadCache()) {
                return $this;
            }
        }

        $mergeConfig = Mage::getModel('core/config_base');
        $config = Mage::getConfig();

        // Load additional config files
        $this->_addConfigFile('cms.xml', $mergeConfig);
        $this->_addConfigFile('email.xml', $mergeConfig);
        $this->_addConfigFile('systemconfig.xml', $mergeConfig);
        $this->_addConfigFile('tax.xml', $mergeConfig);

        $this->setXml($config->getNode());

        if (Mage::app()->useCache(self::CACHE_ID)) {
            $this->saveCache();
        }

        return $this;
    }

    /**
     * @param $fileName
     * @param $mergeConfig
     */
    protected function _addConfigFile($fileName, $mergeConfig)
    {
        $country = Mage::app()->getRequest()->getParam('country');

        $config = Mage::getConfig();
        $configFile = $config->getModuleDir('etc', 'FireGento_GermanSetup') . DS . $country . DS . $fileName;
        if (!file_exists($configFile)) {
            $configFile = $config->getModuleDir('etc', 'FireGento_GermanSetup') . DS . 'default' . DS . $fileName;
        }
        if (file_exists($configFile)) {
            if ($mergeConfig->loadFile($configFile)) {
                $config->extend($mergeConfig, true);
            }
        }
    }
}
