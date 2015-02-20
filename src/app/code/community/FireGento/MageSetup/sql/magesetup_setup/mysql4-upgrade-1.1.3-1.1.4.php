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
 * Setup script; Adds a new table for newsletter subscriber status
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
        DROP TABLE IF EXISTS `{$installer->getTable('magesetup/newsletter_subscriber_status')}`;
        CREATE TABLE `{$installer->getTable('magesetup/newsletter_subscriber_status')}` (
          `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
          `subscriber` int(10) unsigned NOT NULL COMMENT 'Subscriber Id',
          `status` int(11) NOT NULL DEFAULT '0' COMMENT 'Subscriber Status',
          `email` text COMMENT 'Subscriber Status',
          `created_at` timestamp NULL DEFAULT NULL COMMENT 'Changed at',
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Newsletter Subscriber Status Table';
    ");

} else {

    $subscriberStatusTable = $installer->getTable('magesetup/newsletter_subscriber_status');
    if ($installer->getConnection()->isTableExists($subscriberStatusTable)) {
        $installer->getConnection()->dropTable($subscriberStatusTable);
    }

    $subscriberStatusTable = $installer->getConnection()->newTable($subscriberStatusTable)
        ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned' => true,
            'nullable' => false,
            'primary'  => true,
            'identity' => true,
            ),
            'ID'
        )
        ->addColumn('subscriber', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned'  => true,
            'nullable'  => false,
            ),
            'Subscriber Id'
        )
        ->addColumn('status', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'nullable'  => false,
            'default'   => '0',
            ),
            'Subscriber Status'
        )
        ->addColumn('email', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
            ),
            'Subscriber Status'
        )
        ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
            ),
            'Changed at'
        )
        ->setComment('Newsletter Subscriber Status Table');
    $installer->getConnection()->createTable($subscriberStatusTable);

}

$installer->endSetup();
