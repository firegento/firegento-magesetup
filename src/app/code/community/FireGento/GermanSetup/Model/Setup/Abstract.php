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
 * Setup class
 *
 * @category  FireGento
 * @package   FireGento_GermanSetup
 * @author    FireGento Team <team@firegento.com>
 * @copyright 2011 FireGento Team (http://www.firegento.de). All rights served.
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License, version 3 (GPLv3)
 * @version   $Id:$
 * @since     0.2.0
 */
class FireGento_GermanSetup_Model_Setup_Abstract extends Mage_Core_Model_Abstract
{
    /**
     * Get config.xml data
     *
     * @return array
     */
    public function getConfigData()
    {
//        $configData = Mage::getConfig()
//        ->getNode('default/germansetup')
//        ->asArray();
        $configData = Mage::getSingleton('germansetup/config')
            ->getNode('default/germansetup')
            ->asArray();
        return $configData;
    }

    /**
     * Get config.xml data
     *
     * @param string      $node      xml noce
     * @param string|null $childNode if set, child node of the first noce
     *
     * @return array
     */
    protected function _getConfigNode($node, $childNode = null)
    {
        $configData = $this->getConfigData();
        if ($childNode) {
            return $configData[$node][$childNode];
        } else {
            return $configData[$node];
        }
    }

    /**
     * Get template content
     *
     * @param string $filename template file name
     *
     * @return string
     */
    public function getTemplateContent($filename)
    {
        return file_get_contents(Mage::getBaseDir() . DS . $filename);
    }
}
