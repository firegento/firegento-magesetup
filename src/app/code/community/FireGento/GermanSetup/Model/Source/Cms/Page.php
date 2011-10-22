<?php

class FireGento_GermanSetup_Model_System_Config_Source_Cms_Page
    extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
    /**
     * @var array $_options cached options
     */
    protected $_options;

    /**
     * Return option array
     *
     * @return array options
     */
    public function toOptionArray()
    {
        if (!$this->_options) {
            $this->_options = Mage::getModel('cms/page')->getCollection()
                ->addFieldToFilter('is_active', 1)
                ->setOrder('title', 'ASC')
                ->toOptionArray();
        }

        return $this->_options;
    }

    /**
     * Get all options as array
     *
     * @return array options
     */
    public function getAllOptions()
    {
        return $this->toOptionArray();
    }
}
