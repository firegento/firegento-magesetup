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
 * Source model for attribute "agreement_type"
 *
 * @category FireGento
 * @package  FireGento_MageSetup
 * @author   FireGento Team <team@firegento.com>
 */
class FireGento_MageSetup_Model_Source_AgreementType
{
    const AGREEMENT_TYPE_CHECKOUT = 0;
    const AGREEMENT_TYPE_CUSTOMER = 1;
    const AGREEMENT_TYPE_BOTH = 2;
    const AGREEMENT_TYPE_NOWHERE = 3;

    /**
     * Options getter
     *
     * @return array Agreement types as option array
     */
    public function toOptionArray()
    {
        $helper = Mage::helper('magesetup');

        return array(
            array(
                'value' => self::AGREEMENT_TYPE_CHECKOUT,
                'label' => $helper->__('On checkout (Magento Default)')
            ),
            array(
                'value' => self::AGREEMENT_TYPE_CUSTOMER,
                'label' => $helper->__('On customer registration (or on checkout, if customer not registered before)')
            ),
            array(
                'value' => self::AGREEMENT_TYPE_BOTH,
                'label' => $helper->__('On customer registration and on checkout')
            ),
            array(
                'value' => self::AGREEMENT_TYPE_NOWHERE,
                'label' => $helper->__('Nowhere')
            ),
        );
    }

    /**
     * Retrieve all agreements as option hash
     *
     * @return array Agreement types as option hash
     */
    public function getOptionArray()
    {
        $options = array();
        foreach ($this->toOptionArray() as $option) {
            $options[$option['value']] = $option['label'];
        }

        return $options;
    }
}
