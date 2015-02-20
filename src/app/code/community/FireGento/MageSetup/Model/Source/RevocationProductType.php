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
 * @since     2.2.0
 */

/**
 * Source model for attribute "revocation_product_type"
 *
 * @category FireGento
 * @package  FireGento_MageSetup
 * @author   FireGento Team <team@firegento.com>
 */
class FireGento_MageSetup_Model_Source_RevocationProductType extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
    const REVOCATION_PRODUCT_TYPE_DEFAULT = '';
    const REVOCATION_PRODUCT_TYPE_ALL = '';
    const REVOCATION_PRODUCT_TYPE_GOODS = 'goods';
    const REVOCATION_PRODUCT_TYPE_DIGITAL = 'digital';
    const REVOCATION_PRODUCT_TYPE_SERVICE = 'service';

    /**
     * Options getter
     *
     * @return array Product types as option array
     */
    public function toOptionArray()
    {
        $helper = Mage::helper('magesetup');

        return array(
            array(
                'value' => self::REVOCATION_PRODUCT_TYPE_GOODS,
                'label' => $helper->__('Delivery of Goods')
            ),
            array(
                'value' => self::REVOCATION_PRODUCT_TYPE_DIGITAL,
                'label' => $helper->__('Digital Content')
            ),
            array(
                'value' => self::REVOCATION_PRODUCT_TYPE_SERVICE,
                'label' => $helper->__('Service')
            ),
        );
    }

    /**
     * Options getter
     *
     * @return array Product types as option array
     */
    public function getAllOptions()
    {
        $options = array_merge(array(array(
            'value' => self::REVOCATION_PRODUCT_TYPE_DEFAULT,
            'label' => Mage::helper('magesetup')->__('Default (Configuration)'),
        )), $this->toOptionArray());

        return $options;
    }

    /**
     * Retrieve all product types as option hash
     *
     * @return array Product Types as option hash
     */
    public function getOptionArray()
    {
        $options = array(
            self::REVOCATION_PRODUCT_TYPE_ALL => Mage::helper('magesetup')->__('All')
        );
        foreach ($this->toOptionArray() as $option) {
            $options[$option['value']] = $option['label'];
        }

        return $options;
    }
}
