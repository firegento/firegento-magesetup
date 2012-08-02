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
 * @since     0.4.0
 */
/**
 * Displays a form with some options to setup things
 *
 * @category  FireGento
 * @package   FireGento_GermanSetup
 * @author    FireGento Team <team@firegento.com>
 * @copyright 2012 FireGento Team (http://www.firegento.de). All rights served.
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License, version 3 (GPLv3)
 * @version   $Id:$
 * @since     0.4.0
 */
class FireGento_GermanSetup_Block_Adminhtml_Germansetup extends Mage_Adminhtml_Block_Widget
{
    /**
     * Class Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->setTitle('German Setup');
    }

    /**
     * Retrieve the POST URL for the form
     *
     * @return string URL
     */
    public function getPostActionUrl()
    {
        return $this->getUrl('*/*/save');
    }

    /**
     * Get old product tax classes
     *
     * @return array
     */
    public function getProductTaxClasses()
    {
        return Mage::getSingleton('tax/class_source_product')->getAllOptions();
    }

    /**
     * Get new product tax classes (yet to be created)
     *
     * @return array
     */
    public function getNewProductTaxClasses()
    {
        return Mage::getSingleton('germansetup/source_tax_newProductTaxClass')->getAllOptions();
    }

    /**
     * @return int default new tax class (yet to be created)
     */
    public function getDefaultProductTaxClass()
    {
        return Mage::getSingleton('germansetup/source_tax_newProductTaxClass')->getDefaultOption();
    }
}
