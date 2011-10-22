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
 * Enhanced block for product price display of all products in spite of bundles (got own block!).
 * Contains the normal price.phtml rendering and additionally a configured static block.
 *
 * @category  FireGento
 * @package   FireGento_GermanSetup
 * @author    FireGento Team <team@firegento.com>
 * @copyright 2011 FireGento Team (http://www.firegento.de). All rights served.
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License, version 3 (GPLv3)
 * @version   $Id:$
 * @since     0.1.0
 */
class FireGento_GermanSetup_Block_Catalog_ProductPrice extends Mage_Catalog_Block_Product_Price
{
    /**
     * Add content of static block below price html if defined in config
     *
     * @return string
     */
    public function _toHtml()
    {
        $html = trim(parent::_toHtml());

        if (empty($html)) {
            return '';
        }

        $blockIdentifier = Mage::getStoreConfig('catalog/price/block_below_price');

        if ($blockIdentifier) {
            $blockModel = Mage::getModel('cms/block')
                ->setStoreId(Mage::app()->getStore()->getId())
                ->load($blockIdentifier);

            if ($blockModel->getId() && $blockModel->getIsActive()) {
                $html .= $this->getLayout()->createBlock('cms/block')->setBlockId($blockModel->getId())->toHtml();
            }

        }
        return $html;
    }
}