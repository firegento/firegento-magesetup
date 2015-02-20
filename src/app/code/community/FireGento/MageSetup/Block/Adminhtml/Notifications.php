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
 * @since     0.4.0
 */

/**
 * Displays MageSetup notifications
 *
 * @category FireGento
 * @package  FireGento_MageSetup
 * @author   FireGento Team <team@firegento.com>
 */
class FireGento_MageSetup_Block_Adminhtml_Notifications extends Mage_Adminhtml_Block_Template
{
    /**
     * Disable the block caching for this block
     */
    protected function _construct()
    {
        parent::_construct();
        $this->addData(array('cache_lifetime' => null));
    }

    /**
     * Returns a value that indicates if some of the magesetup settings have already been initialized.
     *
     * @return bool Flag if MageSetup is already initialized
     */
    public function isInitialized()
    {
        return Mage::getStoreConfigFlag('magesetup/is_initialized');
    }

    /**
     * Get magesetup management url
     *
     * @return string URL for MageSetup form
     */
    public function getManageUrl()
    {
        return $this->getUrl('magesetup/magesetup');
    }

    /**
     * Get magesetup installation skip action
     *
     * @return string URL for skip action
     */
    public function getSkipUrl()
    {
        return $this->getUrl('adminhtml/magesetup/skip');
    }

    /**
     * ACL validation before html generation
     *
     * @return string Notification content
     */
    protected function _toHtml()
    {
        if (Mage::getSingleton('admin/session')->isAllowed('system/magesetup')) {
            return parent::_toHtml();
        }

        return '';
    }
}
