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
 * @copyright 2014 FireGento Team (http://www.firegento.com)
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License, version 3 (GPLv3)
 * @since     2.3.0
 */
/**
 * Flag class
 *
 * @category FireGento
 * @package  FireGento_MageSetup
 * @author   FireGento Team <team@firegento.com>
 */


class FireGento_MageSetup_Model_System_Config_Backend_Tax_Config extends Mage_Core_Model_Config_Data
{
    protected function _afterSave()
    {
        // This work-around might be neccessary due to less meaningful config values in the future
        // So we can reuse config value '2' for dynamic shipping tax calc algo without
        // confusing it with the prior 2.2.0 version

        $flag = Mage::getModel('magesetup/shippingtax_flag')->loadSelf();
        if ($flag->getFlagData() == 'wrong') {
            $flag->setFlagData('fixed')->save();
        }
        return parent::_afterSave();
    }


}