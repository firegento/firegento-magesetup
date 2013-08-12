<?php
class FireGento_MageSetup_Model_Source_Tax_DynamicType
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $helper = Mage::helper('magesetup');
        return array(
            array(
                'value' => 0,
                'label' => $helper->__('No dynamic shipping tax caluclation')
            ),
            array(
                'value' => FireGento_MageSetup_Model_Tax_Config::USE_HIGHTES_TAX_ON_PRODUCTS,
                'label' => $helper->__('Use the highest product tax')
            ),
            array(
                'value' => FireGento_MageSetup_Model_Tax_Config::USE_TAX_DEPENDING_ON_PRODUCT_VALUES,
                'label' => $helper->__('Use the tax rate of products that make up the biggest amount')
            ),
        );
    }
}
