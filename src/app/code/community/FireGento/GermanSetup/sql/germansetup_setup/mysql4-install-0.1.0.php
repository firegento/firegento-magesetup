<?php
<<<<<<< HEAD
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
        'label'        => 'Lieferzeit',
        'input'        => 'text',
        'required'     => false,
        'user_defined' => true,
        'default'      => '2-3 Tage',
        'group'        => 'General',
    )
);

$installer->updateAttribute(
    'catalog_product',
    'delivery_time',
    array(
        'is_global'                     => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
        'is_visible'                    => true,
        'is_filterable'                 => true,
        'is_searchable'                 => true,
        'is_comparable'                 => true,
        'is_visible_on_front'           => true,
        'is_visible_in_advanced_search' => true,
        'used_in_product_listing'       => true,
        'is_html_allowed_on_front'      => true,
    )
);

$installer->endSetup();
=======

$installer = $this;
$installer->startSetup();

// execute pages
foreach ($this->getConfigPages() as $name => $data) {
    if ($data['execute'] == 1) {
        if ($name == 'symmetrics_mrgbeispiel') {
            // create inactive CMS page
            $this->createCmsPage($data, '0');
        } else {
            $this->createCmsPage($data);
        }
    }
}

// execute blocks
foreach ($this->getConfigBlocks() as $name => $data) {
    if ($data['execute'] == 1) {
        if ($name == 'mrg_footerlinks') {
            $this->updateFooterLinksBlock($data);
        } else {
            $this->createCmsBlock($data, true);
        }
    }
}

// execute emails
foreach ($this->getConfigEmails() as $name => $data) {
    if ($data['execute'] == 1) {
        $this->createEmail($data);
    }
}

// set some misc data
$installer->setConfigData('sales_pdf/invoice/put_order_id', '1');
$installer->setConfigData('sales_pdf/shipment/put_order_id', '1');
$installer->setConfigData('sales_pdf/creditmemo/put_order_id', '1');
$installer->setConfigData('sales/identity/logo', 'default/logo.jpg');
$installer->setConfigData('tax/display/shippingurl', 'lieferung');
>>>>>>> 67ca5196235da3d779a1c49cfa4dc9eb0550355a
