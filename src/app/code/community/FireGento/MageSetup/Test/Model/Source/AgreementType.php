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
 * @copyright 2013-2015 FireGento Team (http://www.firegento.com)
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License, version 3 (GPLv3)
 * @version   2.2.2
 * @since     2.0.0
 */
/**
 * PHPUnit Test Class
 *
 * @category FireGento
 * @package  FireGento_MageSetup
 * @author   FireGento Team <team@firegento.com>
 */
class FireGento_MageSetup_Test_Model_Source_AgreementType extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @var FireGento_MageSetup_Model_Source_AgreementType
     */
    protected $_model;

    /**
     * Sets up the model class
     */
    protected function setUp()
    {
        parent::setUp();
        $this->_model = Mage::getModel('magesetup/source_agreementType');
    }

    /**
     * Test the toOptionArray method
     */
    public function testToOptionArray()
    {
        $actual = $this->_model->toOptionArray();
        $expected = $this->expected('result')->getData();

        $this->assertEquals(
            $expected,
            $actual
        );
    }

    /**
     * Test the getOptionArray method
     */
    public function testGetOptionArray()
    {
        $actual = $this->_model->getOptionArray();
        $expected = $this->expected('result')->getData();

        $this->assertEquals(
            $expected,
            $actual
        );
    }
}
