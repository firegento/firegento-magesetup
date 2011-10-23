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
 * @since     0.4.0
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
 * @since     0.4.0
 */

/* @var $installer Mage_Eav_Model_Entity_Setup */
$installer = $this;
$installer->startSetup();

$agreements = array(
    array(
        'name'          => 'AGB',
        'content'       => '{{block type="cms/block" block_id="gs_business_terms"}}',
        'checkbox_text' => 'Ich habe die Allgemeinen Geschäftsbedingungen gelesen und stimme diesen ausdrücklich zu.'
    ),
    array(
        'name'          => 'Widerrufsbelehrung',
        'content'       => '{{block type="cms/block" block_id="gs_revocation"}}',
        'checkbox_text' => 'Ich habe die Widerrufsbelehrung gelesen.'
    )
);
foreach ($agreements as $agreement) {
    $model = Mage::getModel('checkout/agreement');
    $model->setData($agreement);
    $model->save();
}
$installer->setConfigData('checkout/options/enable_agreements', '1');
$installer->endSetup();
