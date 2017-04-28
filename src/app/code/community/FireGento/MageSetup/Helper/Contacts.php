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

    /** @var string $_moduleName Module name */
    protected $_moduleName = 'FireGento_MageSetup';

    public function isAcceptAgreement()
    {
        return Mage::getStoreConfig(self::XML_PATH_ACCEPT_AGREEMENT);
    }
}
