<?php
/**
 * This file is part of the FIREGENTO project.
 *
 * FireGento_MageSetup is free software; you can redistribute it and/or
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
 * @copyright 2013 FireGento Team (http://www.firegento.de). All rights served.
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License, version 3 (GPLv3)
 * @version   $Id:$
 * @since     0.2.0
 */
/**
 * Setup class
 *
 * @category  FireGento
 * @package   FireGento_MageSetup
 * @author    FireGento Team <team@firegento.com>
 * @copyright 2013 FireGento Team (http://www.firegento.de). All rights served.
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License, version 3 (GPLv3)
 * @version   $Id:$
 * @since     0.2.0
 */
class FireGento_MageSetup_Model_Setup_Abstract extends Mage_Core_Model_Abstract
{
    /**
     * @var Mage_Eav_Model_Entity_Setup
     */
    protected $_setup;

    /**
     * @var Varien_Db_Adapter_Interface
     */
    protected $_connection;

    /**
     * Setup setup class and connection
     */
    public function __construct()
    {
        $this->_setup = Mage::getModel('eav/entity_setup', 'core_setup');
        $this->_connection = $this->_setup->getConnection();
    }

    /**
     * Get config.xml data
     *
     * @return array
     */
    public function getConfigData()
    {
        $configData = Mage::getSingleton('magesetup/config')
            ->getNode('default/magesetup')
            ->asArray();

        return $configData;
    }

    /**
     * @param string $configPath
     * @param string $value
     * @param int|null $storeId
     */
    public function setConfigData($configPath, $value, $storeId = null)
    {
        $setup = $this->_getSetup();
        if (is_null($storeId)) {
            $setup->setConfigData($configPath, $value);
        } else {
            $setup->setConfigData($configPath, $value, 'stores', $storeId);
        }
    }

    /**
     * Get config.xml data
     *
     * @param string      $node      xml node
     * @param string|null $childNode if set, child node of the first node
     *
     * @return array
     */
    protected function _getConfigNode($node, $childNode = null)
    {
        $configData = $this->getConfigData();
        if ($childNode) {
            return $configData[$node][$childNode];
        } else {
            return $configData[$node];
        }
    }

    /**
     * Get template content
     *
     * @param string $filename template file name
     * @return string
     */
    public function getTemplateContent($filename)
    {
        return @file_get_contents($filename);
    }

    /**
     * Load a model by attribute code
     *
     * @param  Mage_Core_Model_Abstract $model
     * @param  string                   $attributeCode
     * @param  string                   $value
     * @return Mage_Core_Model_Abstract
     */
    protected function _loadExistingModel($model, $attributeCode, $value)
    {
        foreach ($model->getCollection() as $singleModel) {
            if ($singleModel->getData($attributeCode) == $value) {
                $model->load($singleModel->getId());

                return $model;
            }
        }

        return $model;
    }

    /**
     * @return Varien_Db_Adapter_Interface
     */
    protected function _getConnection()
    {
        return $this->_connection;
    }

    /**
     * @return Mage_Eav_Model_Entity_Setup
     */
    protected function _getSetup()
    {
        return $this->_setup;
    }
}