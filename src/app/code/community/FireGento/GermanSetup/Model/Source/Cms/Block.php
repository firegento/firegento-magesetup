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
 * @since     0.1.0
 */
/**
 * CMS Source model for configuration dropdown of CMS static blocks
 *
 * @category  FireGento
 * @package   FireGento_GermanSetup
 * @author    FireGento Team <team@firegento.com>
 * @copyright 2012 FireGento Team (http://www.firegento.de). All rights served.
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License, version 3 (GPLv3)
 * @version   $Id:$
 * @since     0.1.0
 */
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

            foreach ($blocks as $block) {
                $options[$block->getIdentifier()] = $block->getIdentifier();
            }

            foreach ($options as $identifier) {
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
