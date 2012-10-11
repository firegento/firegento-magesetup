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
 * @since     1.0.5
 */
/**
 * Changed product configuration to add product attributes on checkout
 *
 * @category  FireGento
 * @package   FireGento_GermanSetup
 * @author    FireGento Team <team@firegento.com>
 * @copyright 2012 FireGento Team (http://www.firegento.de). All rights served.
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License, version 3 (GPLv3)
 * @version   $Id:$
 * @since     1.0.5
 */
class FireGento_GermanSetup_Helper_Catalog_Product_Configuration
    extends Mage_Catalog_Helper_Product_Configuration
{
    /**
     * @var array
     */
    protected $_finished = array();

    /**
     * @var array
     */
    protected $_products = array();

    /**
     * Merge Attributes
     *
     * @see parent::getCustomOptions()
     * @param  Mage_Catalog_Model_Product_Configuration_Item_Interface $item
     * @return array
     */
    public function getCustomOptions(Mage_Catalog_Model_Product_Configuration_Item_Interface $item)
    {
        $optionsParent = parent::getCustomOptions($item);
        $optionsSelf   = $this->_getAttributes($item);
        $options       = array_merge($optionsSelf, $optionsParent);

        return $options;
    }

    /**
     * Get the product for the current quote item
     *
     * @param  Mage_Catalog_Model_Product_Configuration_Item_Interface $item
     * @return Mage_Catalog_Model_Product
     */
    protected function _getProduct($item)
    {
        $productId = $item->getProduct()->getId();
        if (!array_key_exists($productId, $this->_products)) {
            /* @var $product Mage_Catalog_Model_Product */
            $product = Mage::getModel('catalog/product')
                ->setStoreId(Mage::app()->getStore()->getId())
                ->load($productId);

            $this->_products[$productId] = $product;
        }

        return $this->_products[$productId];
    }

    /**
     * Retreve the product attributes
     *
     * @param  Mage_Catalog_Model_Product_Configuration_Item_Interface $item
     * @return array
     */
    protected function _getAttributes($item)
    {
        $itemId = $item->getId();
        if (!isset($this->_finished[$itemId])) {
            $this->_finished[$itemId] = true;
            $product    = $this->_getProduct($item);
            $attributes = $this->_getAdditionalData($product);
            if (count($attributes) > 0) {
                return $attributes;
            }
        }

        return array();
    }

    /**
     * Retrieve the attributes which are visible on the checkout page
     *
     * @param  Mage_Catalog_Model_Product $product
     * @return array
     */
    protected function _getAdditionalData(Mage_Catalog_Model_Product $product)
    {
        $data = array();

        $attributes = $product->getAttributes();
        foreach ($attributes as $attribute) {
            if ($attribute->getIsVisibleOnCheckout()) {
                $value = $attribute->getFrontend()->getValue($product);
                if (!$product->hasData($attribute->getAttributeCode()) || (string) $value == '') {
                    $value = '';
                } elseif ($attribute->getFrontendInput() == 'price' && is_string($value)) {
                    $value = Mage::app()->getStore()->convertPrice($value, true);
                }

                if (is_string($value) && strlen($value)) {
                    $data[$attribute->getAttributeCode()] = array(
                        'label'       => $attribute->getStoreLabel(),
                        'value'       => $value,
                        'print_value' => $value,
                        'code'        => $attribute->getAttributeCode()
                    );
                }
            }
        }

        return $data;
    }
}
