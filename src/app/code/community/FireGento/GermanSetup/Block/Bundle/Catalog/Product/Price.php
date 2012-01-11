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
 * @copyright 2011 FireGento Team (http://www.firegento.de). All rights served.
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License, version 3 (GPLv3)
 * @version   $Id:$
 * @since     0.1.0
 */
/**
 * Enhanced block for product price display of bundle products. Contains the normal price.phtml
 * rendering and additionally a configured static block.
 *
 * @category  FireGento
 * @package   FireGento_GermanSetup
 * @author    FireGento Team <team@firegento.com>
 * @copyright 2011 FireGento Team (http://www.firegento.de). All rights served.
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License, version 3 (GPLv3)
 * @version   $Id:$
 * @since     0.1.0
 */
class FireGento_GermanSetup_Block_Bundle_Catalog_Product_Price extends Mage_Bundle_Block_Catalog_Product_Price
{
    /**
     * Add content of template block below price html if defined in config
     *
     * @return string
     */
    public function _toHtml()
    {
        $html = trim(parent::_toHtml());

        if (empty($html)) {
            return '';
        }

        if (!Mage::getStoreConfigFlag('catalog/price/display_block_below_price')) {
            return $html;
        }

        $html .= $this->getLayout()->createBlock('core/template')
            ->setTemplate('germansetup/price_info.phtml')
            ->toHtml();

        return $html;
    }
}