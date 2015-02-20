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
 * @since     1.0.5
 */
/**
 * Setup script; Adds a new column 'Visible in Checkout' to attributes
 *
 * @category FireGento
 * @package  FireGento_MageSetup
 * @author   FireGento Team <team@firegento.com>
 */

/* @var $this Mage_Eav_Model_Entity_Setup */
$installer = $this;
$installer->startSetup();

if (version_compare(Mage::getVersion(), '1.6', '<')) {

    $installer->run("
        ALTER TABLE `{$installer->getTable('catalog/eav_attribute')}`
        ADD `is_visible_on_checkout` SMALLINT(5) NOT NULL DEFAULT '0';
    ");

} else {

    $installer->getConnection()->addColumn(
        $installer->getTable('catalog/eav_attribute'),
        'is_visible_on_checkout',
        array(
            'type'     => Varien_Db_Ddl_Table::TYPE_SMALLINT,
            'unsigned' => true,
            'nullable' => false,
            'default'  => '0',
            'comment'  => 'Visible in Checkout'
        )
    );

}

$installer->endSetup();
