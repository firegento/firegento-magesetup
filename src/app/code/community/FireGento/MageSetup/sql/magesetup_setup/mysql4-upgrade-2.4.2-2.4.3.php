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
 * @copyright 2013-2018 FireGento Team (http://www.firegento.com)
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License, version 3 (GPLv3)
 */
/**
 * @category FireGento
 * @package  FireGento_MageSetup
 * @author   FireGento Team <team@firegento.com>
 */

$installer = $this;

$installer->startSetup();

if (version_compare(Mage::getVersion(), '1.6', '<')) {
    $installer->run("
        DROP TABLE IF EXISTS `{$installer->getTable('magesetup/consent')}`;
        CREATE TABLE `{$installer->getTable('magesetup/consent')}` (
          `consent_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
          `ip` VARCHAR(45) NOT NULL COMMENT 'IP address of user doing the consent',
          `date` DATETIME NOT NULL COMMENT 'time of consent',
          `consent_user` VARCHAR(255) NOT NULL COMMENT 'user doing the consent',
          `consent_type` VARCHAR(255) NOT NULL COMMENT 'area of consent (e.g. contactform or newsletter)',
          `consent` VARCHAR(5) NOT NULL COMMENT 'separate saved consent for lawyer',
          PRIMARY KEY (`consent_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='MageSetup consent table';
    ");

} else {
    $consentTable = $installer->getTable('magesetup/consent');
    if ($installer->getConnection()->isTableExists($consentTable)) {
        $installer->getConnection()->dropTable($consentTable);
    }

    $consentTable = $installer->getConnection()->newTable($consentTable)
        ->addColumn('consent_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity' => true,
            'unsigned' => true,
            'nullable' => false,
            'primary' => true,
        ), 'id of consent')
        ->addColumn('ip', Varien_Db_Ddl_Table::TYPE_VARCHAR, 45, array(
            'nullable' => true,
        ), 'IP address of user doing the consent')
        ->addColumn('date', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
            'nullable' => false,
        ), 'time of consent')
        ->addColumn('consent_user', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
            'nullable' => false,
        ), 'user doing the consent')
        ->addColumn('consent_type', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable' => false,
        ), 'area of consent (e.g. contactform or newsletter)')
        ->addColumn('consent', Varien_Db_Ddl_Table::TYPE_TINYINT, 5, array(
            'unsigned' => true,
            'nullable' => false,
        ), 'separate saved consent for lawyer');
    $installer->getConnection()->createTable($consentTable);
}

$installer->endSetup();