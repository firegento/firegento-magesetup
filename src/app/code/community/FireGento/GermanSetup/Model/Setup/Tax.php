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
 * Setup class for Tax Settings
 *
 * @category  FireGento
 * @package   FireGento_GermanSetup
 * @author    FireGento Team <team@firegento.com>
 * @copyright 2012 FireGento Team (http://www.firegento.de). All rights served.
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License, version 3 (GPLv3)
 * @version   $Id:$
 * @since     0.5.0
 */
class FireGento_GermanSetup_Model_Setup_Tax extends FireGento_GermanSetup_Model_Setup_Abstract
{
    /**
     * @var FireGento_GermanSetup_Model_Setup
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
     * Setup Tax setting
     *
     * @return void
     */
    public function setup()
    {
        // execute tax classes
        $this->_truncateTable('tax_class');

        foreach ($this->_getConfigTaxClasses() as $data) {
            if ($data['execute'] == 1) {
                unset($data['default']);
                $this->_createTaxClass($data);
            }
        }

        // execute tax calculation rules
        $this->_truncateTable('tax_calculation_rule');

        foreach ($this->_getConfigTaxCalcRules() as $data) {
            if ($data['execute'] == 1) {
                $this->_createTaxCalcRule($data);
            }
        }

        // execute tax calculation rates
        $this->_truncateTable('tax_calculation_rate');
        $this->_truncateTable('tax_calculation_rate_title');

        foreach ($this->_getConfigTaxCalcRates() as $data) {
            if ($data['execute'] == 1) {
                $this->_createTaxCalcRate($data);
            }
        }

        // execute tax calculations
        $this->_truncateTable('tax_calculation');

        foreach ($this->_getConfigTaxCalculations() as $data) {
            if ($data['execute'] == 1) {
                $this->_createTaxCalculation($data);
            }
        }

        // modify config data
        $this->_updateConfigData();
    }

    /**
     * Get tax classes from config file
     *
     * @return array
     */
    protected function _getConfigTaxClasses()
    {
        return $this->_getConfigNode('tax_classes', 'default');
    }

    /**
     * Collect data and create tax class
     *
     * @param  array $taxClassData tax class data
     * @return void
     */
    protected function _createTaxClass($taxClassData)
    {
        $this->_insertIntoTable('tax_class', $taxClassData);
    }

    /**
     * Get tax calculation rules from config file
     *
     * @return array
     */
    protected function _getConfigTaxCalcRules()
    {
        return $this->_getConfigNode('tax_calculation_rules', 'default');
    }

    /**
     * Collect data and create tax calculation rules
     *
     * @param  array $taxCalcRuleData tax class data
     * @return void
     */
    protected function _createTaxCalcRule($taxCalcRuleData)
    {
        $this->_insertIntoTable('tax_calculation_rule', $taxCalcRuleData);
    }

    /**
     * Get tax calculation rates from config file
     *
     * @return array
     */
    protected function _getConfigTaxCalcRates()
    {
        return $this->_getConfigNode('tax_calculation_rates', 'default');
    }

    /**
     * Collect data and create tax calculation rates
     *
     * @param  array $taxCalcRateData tax class data
     * @return void
     */
    protected function _createTaxCalcRate($taxCalcRateData)
    {
        // look up label
        $label = '';
        if (isset($taxCalcRateData['label'])) {

            $label = $taxCalcRateData['label'];
            unset($taxCalcRateData['label']);
        }

        // base tax rate db entry
        $this->_insertIntoTable('tax_calculation_rate', $taxCalcRateData);

        // add labels to all store views
        if ($label) {
            foreach (Mage::app()->getStores() as $storeId => $store) {
                $this->_insertIntoTable(
                    'tax_calculation_rate_title',
                    array(
                        'tax_calculation_rate_id' => $taxCalcRateData['tax_calculation_rate_id'],
                        'store_id' => $storeId,
                        'value' => $label,
                    )
                );
            }
        }
    }

     /**
      * Get tax calculations from config file
      *
      * @return array
      */
    protected function _getConfigTaxCalculations()
    {
        return $this->_getConfigNode('tax_calculations', 'default');
    }

    /**
     * Collect data and create tax calculations
     *
     * @param array $taxCalculationData tax class data
     *
     * @return void
     */
    protected function _createTaxCalculation($taxCalculationData)
    {
        $this->_insertIntoTable('tax_calculation', $taxCalculationData);
    }

    /**
     * Update configuration settings
     *
     * @return void
     */
    protected function _updateConfigData()
    {
        $setup = $this->_getSetup();
        foreach ($this->_getConfigTaxConfig() as $key => $value) {
            $setup->setConfigData(str_replace('__', '/', $key), $value);
        }
    }

    /**
     * Get tax calculations from config file
     *
     * @return array
     */
    protected function _getConfigTaxConfig()
    {
        return $this->_getConfigNode('tax_config', 'default');
    }

    /**
     * Update the tax class of all products with specified tax class id
     *
     * @param int $source source tax class id
     * @param int $target target tax class id
     */
    public function updateProductTaxClasses($source, $target)
    {
        if (!Mage::getModel('tax/class')->load(intval($target))->getId()) {
            return;
        }

        $productCollection = Mage::getModel('catalog/product')
            ->getCollection()
            ->addAttributeToFilter('tax_class_id', intval($source));

        foreach ($productCollection as $product) {

            /** @var $product Mage_Catalog_Model_Product */
            $product->setTaxClassId(intval($target));
            $product->getResource()->saveAttribute($product, 'tax_class_id');
        }
    }

    /**
     * Truncate a database table
     *
     * @param  string $table
     * @return void
     */
    protected function _truncateTable($table)
    {
        $tableName = $this->_getSetup()->getTable($table);
        $this->_getConnection()->delete($tableName);
    }

    /**
     * Insert a line into a database table
     *
     * @param  string $table
     * @param  array  $data
     * @return void
     */
    protected function _insertIntoTable($table, $data)
    {
        unset($data['execute']);
        $tableName = $this->_getSetup()->getTable($table);
        $this->_getConnection()->insert($tableName, $data);
    }

    /**
     * @return Varien_Db_Adapter_Interface
     */
    protected function _getConnection()
    {
        return $this->_connection;
    }

    /**
     * @return FireGento_GermanSetup_Model_Setup|Mage_Core_Model_Abstract
     */
    protected function _getSetup()
    {
        return $this->_setup;
    }
}
