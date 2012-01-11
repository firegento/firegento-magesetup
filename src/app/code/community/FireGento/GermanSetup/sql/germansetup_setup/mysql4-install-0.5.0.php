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
 * Setup script; Adds the delivery_time attribute for products
 * and creates all initial pages, blocks and emails
 *
 * @category  FireGento
 * @package   FireGento_GermanSetup
 * @author    FireGento Team <team@firegento.com>
 * @copyright 2011 FireGento Team (http://www.firegento.de). All rights served.
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License, version 3 (GPLv3)
 * @version   $Id:$
 * @since     0.1.0
 */

/* @var $installer Mage_Eav_Model_Entity_Setup */
$installer = $this;
$installer->startSetup();

$installer->addAttribute(
    'catalog_product',
    'delivery_time',
    array(
        'label'                      => 'Lieferzeit',
        'input'                      => 'text',
        'required'                   => false,
        'user_defined'               => true,
        'default'                    => '2-3 Tage',
        'group'                      => 'General',
        'global'                     => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
        'visible'                    => true,
        'filterable'                 => false,
        'searchable'                 => false,
        'comparable'                 => true,
        'visible_on_front'           => true,
        'visible_in_advanced_search' => true,
        'used_in_product_listing'    => true,
        'is_html_allowed_on_front'   => true,
    )
);

/** @todo Set correct admin url */
$notification = Mage::getModel('adminnotification/inbox')
    ->setTitle(Mage::helper('germansetup')->__('German Setup has been installed. Click <a href=="%s">here</a> to set up your pages, blocks, emails and tax settings.', Mage::getUrl('adminhtml/germansetup')))
    ->setDescription(Mage::helper('germansetup')->__('German Setup has been installed. Click <a href=="%s">here</a> to set up your pages, blocks, emails and tax settings.', Mage::getUrl('adminhtml/germansetup')))
    ->setUrl(Mage::helper('adminhtml')->getUrl('adminhtml/germansetup'))
    ->setSeverity(Mage_AdminNotification_Model_Inbox::SEVERITY_NOTICE)
    ->save();

$installer->endSetup();

