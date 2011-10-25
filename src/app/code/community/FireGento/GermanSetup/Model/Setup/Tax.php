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
 * @since     0.2.0
 */
/**
 * Setup class for Tax Settings
 *
 * @category  FireGento
 * @package   FireGento_GermanSetup
 * @author    FireGento Team <team@firegento.com>
 * @copyright 2011 FireGento Team (http://www.firegento.de). All rights served.
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License, version 3 (GPLv3)
 * @version   $Id:$
 * @since     0.5.0
 */
class FireGento_GermanSetup_Model_Setup_Tax extends FireGento_GermanSetup_Model_Setup_Abstract
{
    /**
     * Setup Pages, Blocks and especially Footer Block
     *
     * @return void
     */
    public function setup()
    {
        // execute pages
        foreach ($this->_getConfigTaxClasses() as $name => $data) {
            if ($data['execute'] == 1) {
                $this->_createTaxClass($data, false);
            }
        }
    }

    /**
     * Get tax classes from config file
     *
     * @return array
     */
    protected function _getConfigTaxClasses()
    {
        return $this->_getConfigNode('tax_classes', 'default');
    }

    /**
     * Collect data and create tax class
     *
     * @param array   $taxClassData tax class data
     * @param boolean $override  override tax class if it exists
     *
     * @return void
     */
    protected function _createTaxClass($taxClassData, $override=true)
    {
        $model = Mage::getModel('cms/block');
        $block = $model->load($taxClassData['identifier']);
        $taxClassData['content'] = $this->getTemplateContent($taxClassData['text']);
        if (!$block->getId()) {
            $taxClassData['stores'] = array('0');
            $taxClassData['is_active'] = '1';

            $model->setData($taxClassData)->save();
        } else {
            if ($override) {
                $taxClassData['stores'] = array('0');
                $taxClassData['is_active'] = '1';
                $taxClassData['block_id'] = $block->getId();
                $model->setData($taxClassData)->save();
            }
        }
    }
}
