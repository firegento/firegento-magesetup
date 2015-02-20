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
 * @since     1.0.7
 */
/**
 * Setup script; Adds the is_required field for the checkout agreements
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
        ALTER TABLE `{$installer->getTable('checkout/agreement')}`
        ADD `is_required` SMALLINT( 5 ) NOT NULL DEFAULT '1' COMMENT 'Agreement is Required'
    ");

} else {

    $installer->getConnection()->addColumn(
            $installer->getTable('checkout/agreement'),
            'is_required',
            array(
                'type'      => Varien_Db_Ddl_Table::TYPE_SMALLINT,
                'unsigned'  => true,
                'nullable'  => false,
                'default'   => '1',
                'comment'   => 'Agreement is Required'
            )
        );
}

$installer->endSetup();
