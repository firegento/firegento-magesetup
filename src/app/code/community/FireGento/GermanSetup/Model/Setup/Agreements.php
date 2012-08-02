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
 * @copyright 2012 FireGento Team (http://www.firegento.de). All rights served.
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License, version 3 (GPLv3)
 * @version   $Id:$
 * @since     0.2.0
 */
/**
 * Setup class for Checkout Agreements
 *
 * @category  FireGento
 * @package   FireGento_GermanSetup
 * @author    FireGento Team <team@firegento.com>
 * @copyright 2012 FireGento Team (http://www.firegento.de). All rights served.
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License, version 3 (GPLv3)
 * @version   $Id:$
 * @since     0.5.0
 */
class FireGento_GermanSetup_Model_Setup_Agreements extends FireGento_GermanSetup_Model_Setup_Abstract
{
    /**
     * Setup Checkout Agreements
     *
     * @return void
     */
    public function setup()
    {
        // Build and create agreements
        $agreements = array(
            array(
                'name' => 'AGB',
                'content' => '{{block type="cms/block" block_id="gs_business_terms"}}',
                'checkbox_text'
                    => 'Ich habe die Allgemeinen Geschäftsbedingungen gelesen und stimme diesen ausdrücklich zu.',
                'is_active' => '1',
                'is_html' => '1',
                'stores' => array('0')
            ),
            array(
                'name' => 'Widerrufsbelehrung',
                'content' => '{{block type="cms/block" block_id="gs_revocation"}}',
                'checkbox_text' => 'Ich habe die Widerrufsbelehrung gelesen.',
                'is_active' => '1',
                'is_html' => '1',
                'stores' => array('0')
            )
        );
        foreach ($agreements as $agreement) {
            $model = Mage::getModel('checkout/agreement');
            $model = $this->_loadExistingModel($model, 'name', $agreement['name']);
            $model->addData($agreement);
            $model->save();
        }

        // Set config value to true
        $setup = Mage::getModel('eav/entity_setup', 'core_setup');
        $setup->setConfigData('checkout/options/enable_agreements', '1');
    }
}
