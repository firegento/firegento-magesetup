<?php
/**
 * This file is part of the FIREGENTO project.
 *
 * FireGento_MageSetup is free software; you can redistribute it and/or
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
 * @copyright 2013 FireGento Team (http://www.firegento.de). All rights served.
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License, version 3 (GPLv3)
 * @version   $Id:$
 * @since     0.2.0
 */
/**
 * Setup class for Checkout Agreements
 *
 * @category  FireGento
 * @package   FireGento_MageSetup
 * @author    FireGento Team <team@firegento.com>
 * @copyright 2013 FireGento Team (http://www.firegento.de). All rights served.
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License, version 3 (GPLv3)
 * @version   $Id:$
 * @since     0.5.0
 */
class FireGento_MageSetup_Model_Setup_Agreements extends FireGento_MageSetup_Model_Setup_Abstract
{
    /**
     * Setup Checkout Agreements
     *
     * @return void
     */
    public function setup()
    {
        foreach ($this->_getConfigAgreements() as $name => $data) {
            if ($data['execute'] == 1) {
                $this->_createAgreement($data, false);
            }
        }

        // Set config value to true
        $setup = Mage::getModel('eav/entity_setup', 'core_setup');
        $setup->setConfigData('checkout/options/enable_agreements', '1');
    }

    /**
     * Collect data and create Agreement
     *
     * @param array   $agreementData cms page data
     * @param boolean $override override cms page if it exists
     *
     * @return void
     */
    protected function _createAgreement($agreementData, $override=true)
    {
        if (!is_array($agreementData)) {
            return null;
        }

        $model = Mage::getModel('checkout/agreement');
        $agreement = $this->_loadExistingModel($model, 'name', $agreementData['name']);

        $agreementData = array(
            'name' => $agreementData['name'],
            'content' => $this->getTemplateContent($agreementData['filename']),
            'checkbox_text' => $agreementData['checkbox_text'],
            'is_active' => $agreementData['is_active'],
            'is_html' => $agreementData['is_html'],
            'is_required' => $agreementData['is_required'],
            'agreement_type' => $agreementData['agreement_type'],
            'stores' => array('0'),
        );

        if (!(int) $agreement->getId() || $override) {
            $agreement->setData($agreementData)->save();
        }
    }


    /**
     * Get pages/default from config file
     *
     * @return array
     */
    protected function _getConfigAgreements()
    {
        return $this->_getConfigNode('agreements', 'default');
    }
}
