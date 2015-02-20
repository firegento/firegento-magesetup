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
 * CMS Source model for configuration dropdown of CMS static blocks
 *
 * @category FireGento
 * @package  FireGento_MageSetup
 * @author   FireGento Team <team@firegento.com>
 */
class FireGento_MageSetup_Model_Source_Cms_Block
    extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
    /**
     * @var array $_options cached options
     */
    protected $_options;

    /**
     * Return option array
     *
     * @return array Blocks as option array
     */
    public function toOptionArray()
    {
        if (!$this->_options) {
            /** @var $blocks Mage_Cms_Model_Resource_Block_Collection */
            $blocks = Mage::getModel('cms/block')->getCollection()
                ->addFieldToFilter('is_active', 1)
                ->setOrder('identifier', 'ASC');

            $options = array();

            foreach ($blocks as $block) {
                /** @var $block Mage_Cms_Model_Block */
                $options[$block->getIdentifier()] = $block->getIdentifier();
            }

            foreach ($options as $identifier) {
                $this->_options[] = array(
                    'value' => $identifier,
                    'label' => $identifier,
                );
            }
        }

        array_unshift($this->_options, array('value' => '', 'label' => Mage::helper('magesetup')->__('No Block')));

        return $this->_options;
    }

    /**
     * Get all options as array
     *
     * @return array Blocks as option array
     */
    public function getAllOptions()
    {
        return $this->toOptionArray();
    }
}
