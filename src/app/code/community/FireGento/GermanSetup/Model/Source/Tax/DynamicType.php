<?php
class FireGento_GermanSetup_Model_Source_Tax_DynamicType
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array(
                'value' => 0,
                'label' => Mage::helper('germansetup')->__('No dynamic shipping tax caluclation')
            ),
            array(
                'value' => FireGento_GermanSetup_Model_Tax_Config::USE_HIGHTES_TAX_ON_PRODUCTS,
                'label' => Mage::helper('germansetup')->__('Use the highest product tax')
            ),
            array(
                'value' => FireGento_GermanSetup_Model_Tax_Config::USE_TAX_DEPENDING_ON_PRODUCT_VALUES,
                'label' => Mage::helper('germansetup')->__('Use the tax rate of products that make up the biggest amount')
            ),
        );
    }
}