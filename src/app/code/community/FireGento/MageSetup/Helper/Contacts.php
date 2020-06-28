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
 * @copyright FireGento Team (http://www.firegento.com)
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License, version 3 (GPLv3)
 */

class FireGento_MageSetup_Helper_Contacts extends Mage_Core_Helper_Abstract
{
    const XML_PATH_ACCEPT_AGREEMENT   = 'contacts/contacts/accept_agreement';
    const XML_PATH_REQUIRED_USER_CONTACT_METHOD = 'contacts/contacts/required_user_contact_method';

    /** @var string $_moduleName Module name */
    protected $_moduleName = 'FireGento_MageSetup';

    public function isAcceptAgreement()
    {
        return Mage::getStoreConfig(self::XML_PATH_ACCEPT_AGREEMENT);
    }

    /**
     * check config if telephone is required
     * Hint: on GDPR only email OR telephone can be required
     *
     * @return bool - telephone is required
     */
    public function isTelephoneRequired()
    {
        return Mage::getStoreConfigFlag(self::XML_PATH_REQUIRED_USER_CONTACT_METHOD);
    }

    /**
     * check config if email is required
     * Hint: on GDPR only email OR telephone can be required
     *
     * @return bool - emaile is required
     */
    public function isEmailRequired()
    {
        return !$this->isTelephoneRequired();
    }
}
