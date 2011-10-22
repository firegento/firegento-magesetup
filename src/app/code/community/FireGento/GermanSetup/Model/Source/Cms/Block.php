<?php

class FireGento_GermanSetup_Model_Source_Cms_Block
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
            $blocks = Mage::getModel('cms/block')->getCollection()
                ->addFieldToFilter('is_active', 1)
                ->setOrder('identifier', 'ASC');

            foreach($blocks as $block) {
                $options[$block->getIdentifier()] = $block->getIdentifier();
            }

            foreach($options as $identifier) {
                $this->_options[] = array(
                    'value' => $identifier,
                    'label' => $identifier,
                );
            }
        }


        array_unshift($this->_options, array('value' => '', 'label' => Mage::helper('germansetup')->__('No Block')));

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
