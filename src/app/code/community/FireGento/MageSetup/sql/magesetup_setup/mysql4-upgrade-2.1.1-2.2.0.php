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
 * Setup script; Adds the revocation_product_type attribute for products
 *
 * @category FireGento
 * @package  FireGento_MageSetup
 * @author   FireGento Team <team@firegento.com>
 */

/** @var $installer Mage_Catalog_Model_Resource_Eav_Mysql4_Setup */
$installer = $this;
$installer->startSetup();

$installer->addAttribute(
    'catalog_product',
    'revocation_product_type',
    array(
        'label' => 'Revocation Product Type (for extra checkout agreements)',
        'input' => 'select',
        'source' => 'magesetup/source_revocationProductType',
        'required' => false,
        'user_defined' => true,
        'default' => '',
        'group' => 'Prices',
        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
        'visible' => true,
        'filterable' => false,
        'searchable' => false,
        'comparable' => false,
        'visible_on_front' => false,
        'visible_in_advanced_search' => false,
        'used_in_product_listing' => false,
        'is_html_allowed_on_front' => false,
        'sort_order' => 200,
    )
);

if (version_compare(Mage::getVersion(), '1.6', '<')) {

    $installer->run("
        ALTER TABLE `{$installer->getTable('checkout/agreement')}`
        ADD `revocation_product_type` VARCHAR( 255 ) NOT NULL COMMENT 'Revocation Product Type'
    ");

} else {

    $installer->getConnection()->addColumn(
        $installer->getTable('checkout/agreement'),
        'revocation_product_type',
        array(
            'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
            'length'    => 255,
            'nullable'  => false,
            'default'   => '',
            'comment'   => 'Revocation Product Type'
        )
    );
}

$installer->endSetup();
