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
 */

/**
 * Source model for attribute "required_user_contact_method"
 *
 * @category FireGento
 * @package  FireGento_MageSetup
 * @author   FireGento Team <team@firegento.com>
 */
class FireGento_MageSetup_Model_Source_Contacts_RequiredUserContactMethod
{
    const REQUIRED_FIELD_EMAIL = 0;
    const REQUIRED_FIELD_TELEPHONE = 1;

    /**
     * Options getter
     *
     * @return array required_user_contact_method types as option array
     */
    public function toOptionArray()
    {
        $helper = Mage::helper('magesetup');

        return array(
            array(
                'value' => self::REQUIRED_FIELD_EMAIL,
                'label' => $helper->__('Email')
            ),
            array(
                'value' => self::REQUIRED_FIELD_TELEPHONE,
                'label' => $helper->__('Telephone')
            ),
        );
    }

    /**
     * Retrieve all required_user_contact_method fields as option hash
     *
     * @return array required_user_contact_method types as option hash
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
