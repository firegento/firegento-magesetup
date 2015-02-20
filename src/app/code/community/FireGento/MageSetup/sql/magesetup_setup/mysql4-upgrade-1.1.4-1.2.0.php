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
 * Setup script; Adds the delivery_time attribute for products
 *
 * @category FireGento
 * @package  FireGento_MageSetup
 * @author   FireGento Team <team@firegento.com>
 */

/** @var $installer Mage_Catalog_Model_Resource_Eav_Mysql4_Setup */
$installer = $this;
$installer->startSetup();

// Update attribute properties
$installer->updateAttribute(
    'catalog_product',
    'delivery_time',
    'is_comparable',
    true
);

$installer->updateAttribute(
    'catalog_product',
    'delivery_time',
    'is_visible_on_front',
    true
);

$installer->updateAttribute(
    'catalog_product',
    'delivery_time',
    'is_visible_in_advanced_search',
    true
);

$installer->updateAttribute(
    'catalog_product',
    'delivery_time',
    'used_in_product_listing',
    true
);

$installer->updateAttribute(
    'catalog_product',
    'delivery_time',
    'is_html_allowed_on_front',
    true
);

$installer->updateAttribute(
    'catalog_product',
    'delivery_time',
    'is_visible_on_checkout',
    true
);

$installer->updateAttribute(
    'catalog_product',
    'short_description',
    'is_visible_on_checkout',
    true
);

$installer->endSetup();
