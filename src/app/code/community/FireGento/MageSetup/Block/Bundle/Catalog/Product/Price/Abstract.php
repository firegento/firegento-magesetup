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
 * Enhanced block for product price display of all products in spite of bundles (got own block!).
 * Contains the normal price.phtml rendering and additionally a configured static block.
 *
 * @category FireGento
 * @package  FireGento_MageSetup
 * @author   FireGento Team <team@firegento.com>
 */

// @codingStandardsIgnoreStart
if (Mage::getConfig()->getModuleConfig('Sitewards_B2BProfessional')->is('active', 'true')
    && version_compare(Mage::getConfig()->getModuleConfig('Sitewards_B2BProfessional')->version, '2.1.0', '<=')
) {

    abstract class FireGento_MageSetup_Block_Bundle_Catalog_Product_Price_Abstract
        extends Sitewards_B2BProfessional_Block_Price
    {

    }

} else {

    abstract class FireGento_MageSetup_Block_Bundle_Catalog_Product_Price_Abstract
        extends Mage_Bundle_Block_Catalog_Product_Price
    {

    }

}
// @codingStandardsIgnoreEnd
