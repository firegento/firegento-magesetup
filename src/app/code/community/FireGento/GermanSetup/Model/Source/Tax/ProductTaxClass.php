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
 * @since     0.1.0
 */
/**
 * Tax Source model for new tax classes, possibly not created yet
 *
 * @category  FireGento
 * @package   FireGento_GermanSetup
 * @author    FireGento Team <team@firegento.com>
 * @copyright 2012 FireGento Team (http://www.firegento.de). All rights served.
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License, version 3 (GPLv3)
 * @version   $Id:$
 * @since     1.2.0
 */
class FireGento_GermanSetup_Model_Source_Tax_ProductTaxClass extends Mage_Tax_Model_Class_Source_Product
{
    public function getAllOptions($withEmpty = false)
    {
        $options = parent::getAllOptions($withEmpty);

        foreach($options as $optionKey => $option) {

            if (intval($option['value']) <= 0) {
                continue;
            }

            /** @var $productCollection Mage_Catalog_Model_Resource_Product_Collection */
            $productCollection = Mage::getModel('catalog/product')
                ->getCollection()
                ->addAttributeToFilter('tax_class_id', $option['value'])
                ->setPageSize(1);

            if (!$productCollection->getSize()) {
                unset($options[$optionKey]);
            }
        }

        return $options;
    }
}
