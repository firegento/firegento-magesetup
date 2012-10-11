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
 * Dummy data helper for translation issues.
 *
 * @category  FireGento
 * @package   FireGento_GermanSetup
 * @author    FireGento Team <team@firegento.com>
 * @copyright 2012 FireGento Team (http://www.firegento.de). All rights served.
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License, version 3 (GPLv3)
 * @version   $Id:$
 * @since     0.1.0
 */
class FireGento_GermanSetup_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Generate URL to configured shipping cost page, or '' if none.
     *
     * @return string
     */
    public function getShippingCostUrl()
    {
        /** @var $cmsPage Mage_Cms_Model_Page */
        $cmsPage = Mage::getModel('cms/page')
            ->setStoreId(Mage::app()->getStore()->getId())
            ->load(Mage::getStoreConfig('catalog/price/cms_page_shipping'));

        if (!$cmsPage->getId() || !$cmsPage->getIsActive()) {
            return '';
        }

        return Mage::helper('cms/page')->getPageUrl($cmsPage->getId());
    }

    /**
     * Get url of agreement view for checkout
     *
     * @param  Mage_Checkout_Model_Agreement $agreement
     * @return string
     */
    public function getAgreementUrl(Mage_Checkout_Model_Agreement $agreement)
    {
        return Mage::getUrl('germansetup/frontend/agreements', array('id' => $agreement->getId()));
    }
}
