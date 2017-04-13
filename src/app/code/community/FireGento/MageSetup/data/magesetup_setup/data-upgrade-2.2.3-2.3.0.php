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

// Make sure the upgrade is not performed on legacy installations with tables missing
$adminVersion = Mage::getConfig()->getModuleConfig('Mage_Admin')->version;
if (version_compare($adminVersion, '1.6.1.1', '>')) {
    $connection = $installer->getConnection();

    //---------------------------------------------------
    // Add blocks
    //---------------------------------------------------
    $table = $installer->getTable('admin/permission_block');
    if ($table) {
        $blockNames = array(
            'magesetup/imprint_field',
            'magesetup/imprint_content'
        );
        foreach ($blockNames as $blockName) {
            $connection->insertOnDuplicate(
                $table,
                array(
                    'block_name' => $blockName,
                    'is_allowed' => 1,
                )
            );
        }
    }
}

$installer->endSetup();
