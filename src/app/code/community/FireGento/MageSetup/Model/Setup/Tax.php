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
 * Setup class for Tax Settings
 *
 * @category FireGento
 * @package  FireGento_MageSetup
 * @author   FireGento Team <team@firegento.com>
 */
class FireGento_MageSetup_Model_Setup_Tax extends FireGento_MageSetup_Model_Setup_Abstract
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
     * Setup Tax setting
     *
     * @return void
     */
    public function setup()
    {
        $this->_truncateTable('tax/tax_class');
        $this->_truncateTable('tax/tax_calculation_rule');
        $this->_truncateTable('tax/tax_calculation_rate');
        $this->_truncateTable('tax/tax_calculation_rate_title');
        $this->_truncateTable('tax/tax_calculation');

        // Tax classes
        $taxClasses = array();
        foreach ($this->_getConfigTaxClasses() as $identifier => $data) {
            if ($data['execute'] == 1) {
                unset($data['default']);
                $taxClasses[$identifier] = $this->_createTaxClass($data);
            }
        }


        // Tax Rates
        $taxRates = array();
        foreach ($this->_getConfigTaxCalcRates() as $identifier => $data) {
            $taxRates[$identifier] = array();

            if ($data['execute'] == 1) {
                foreach ($this->_getCountries() as $country) {
                    $data['tax_country_id'] = $country;
                    $data['code'] = $country . ' - ' . $data['label'];
                    $taxRates[$identifier][] = $this->_createTaxCalcRate($data);
                }
            }
        }

        // Tax rules
        foreach ($this->_getConfigTaxCalculations() as $calculation) {
            $data = $calculation->asCanonicalArray();
            if ($data['execute'] == 1) {
                $rule = Mage::getModel('tax/calculation_rule');
                $rule->setData($data);
                foreach ($calculation->attributes() as $attribute => $values) {
                    switch ($attribute) {
                        case 'tax_rate':
                            if (isset($taxRates[(string)$values])) {
                                $rule->setTaxRate($taxRates[(string)$values]);
                            }
                            break;
                        case 'tax_customer_class':
                        case 'tax_product_class':
                            $classes = array();
                            foreach (explode(',', (string)$values) as $value) {
                                if (isset($taxClasses[$value])) {
                                    $classes[] = $taxClasses[$value];
                                }
                            }
                            $rule->setData($attribute, $classes);
                            break;
                    }
                }
                $rule->save();
            }
        }

        // modify config data
        $this->_updateConfigData();
    }

    /**
     * Get countries for tax rate calculations
     *
     * If the country is in the EU, all EU countries
     * are returned. If not, the array only contains the
     * country ID of the configuration setup country
     *
     * @return array
     */
    protected function _getCountries()
    {
        if (Mage::helper('magesetup')->isCountryInEU($this->getCountryId())) {
            return Mage::helper('magesetup')->getEUCountries();
        }

        return array(strtoupper($this->getCountryId()));
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
     * @return int ID of the last inserted item
     */
    protected function _createTaxClass($taxClassData)
    {
        $this->_insertIntoTable('tax/tax_class', $taxClassData);

        return $this->_lastInsertId('tax/tax_class');
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
     * Get tax calculation rates from config file
     *
     * @return array
     */
    public function _getConfigTaxCalcRates()
    {
        return $this->_getConfigNode('tax_calculation_rates', 'default');
    }

    /**
     * Collect data and create tax calculation rates
     *
     * @param  array $taxCalcRateData tax class data
     * @return int ID of the created tax calculation rate
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
        $calculationRateTable = 'tax/tax_calculation_rate';
        $this->_insertIntoTable($calculationRateTable, $taxCalcRateData);
        $rateId = $this->_lastInsertId($calculationRateTable);

        // add labels to all store views
        if ($label) {
            foreach (Mage::app()->getStores() as $storeId => $store) {
                $bind = array(
                    'tax_calculation_rate_id' => $rateId,
                    'store_id'                => $storeId,
                    'value'                   => $label,
                );
                $this->_insertIntoTable('tax/tax_calculation_rate_title', $bind);
            }
        }

        return $rateId;
    }

    /**
     * Get tax calculations from config file
     *
     * @return Varien_Simplexml_Element
     */
    public function _getConfigTaxCalculations()
    {
        $configData = $this->getConfigData();

        return $configData->xpath('//tax_calculation_rules/default/*');
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
     * Update the tax class of all customer groups with specified tax class id
     *
     * @param int $source source tax class id
     * @param int $target target tax class id
     */
    public function updateCustomerTaxClasses($source, $target)
    {
        if (!Mage::getModel('tax/class')->load(intval($target))->getId()) {
            return;
        }

        $customerGroupCollection = Mage::getModel('customer/group')
            ->getCollection()
            ->addFieldToFilter('tax_class_id', intval($source));

        foreach ($customerGroupCollection as $customerGroup) {

            /** @var $customerGroup Mage_Customer_Model_Group */
            $customerGroup->setTaxClassId(intval($target));
            $customerGroup->save();
        }
    }

    /**
     * Truncate a database table
     *
     * DELETE is used, in order to prevent problems with
     * foreign key checks.
     *
     * @param string $table Database to truncate
     */
    protected function _truncateTable($table)
    {
        $tableName = $this->_getTable($table);
        $this->_getConnection()->delete($tableName);
    }

    /**
     * Insert a line into a database table
     *
     * @param string $table Table
     * @param array  $data  Data to insert
     */
    protected function _insertIntoTable($table, $data)
    {
        unset($data['execute']);
        $tableName = $this->_getTable($table);
        $this->_getConnection()->insert($tableName, $data);
    }

    /**
     * Retrieve the database adapter
     *
     * @return Varien_Db_Adapter_Pdo_Mysql Database Adapter
     */
    protected function _getConnection()
    {
        return $this->_connection;
    }

    /**
     * Retrieve the setup class
     *
     * @return Mage_Eav_Model_Entity_Setup Setup Class
     */
    protected function _getSetup()
    {
        return $this->_setup;
    }

    /**
     * Get table name from table alias
     *
     * @param  string $tableAlias Table Alias
     * @return string Correct Table Name
     */
    protected function _getTable($tableAlias)
    {
        return $this->_getSetup()->getTable($tableAlias);
    }

    /**
     * Get last insert ID
     *
     * @param  string $table Table
     * @return int Last inserted id
     */
    protected function _lastInsertId($table)
    {
        $tableName = $this->_getTable($table);

        return $this->_getConnection()->lastInsertId($tableName);
    }
}
