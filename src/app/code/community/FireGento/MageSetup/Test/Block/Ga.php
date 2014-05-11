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
 * @copyright 2013 FireGento Team (http://www.firegento.com)
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License, version 3 (GPLv3)
 * @version   $Id:$
 * @since     2.0.0
 */
/**
 * PHPUnit Test Class
 *
 * @category FireGento
 * @package  FireGento_MageSetup
 * @author   FireGento Team <team@firegento.com>
 */
class FireGento_MageSetup_Test_Block_Ga extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @var FireGento_MageSetup_Block_Ga
     */
    protected $_block;

    /**
     * Set up test class
     */
    protected function setUp()
    {
        parent::setUp();
        $this->_block = $this->app()->getLayout()->createBlock('googleanalytics/ga')->setTemplate('googleanalytics/ga.phtml');
    }

    /**
     * @test
     */
    public function testInstance()
    {
        $this->assertInstanceOf('FireGento_MageSetup_Block_Ga', $this->_block);
        $this->assertInstanceOf('Mage_GoogleAnalytics_Block_Ga', $this->_block);
    }

    /**
     * @test
     * @loadFixture testToHtmlEnabled
     */
    public function testToHtmlEnabled()
    {
        $this->assertContains('_anonymizeIp', $this->_block->toHtml());
    }

    /**
     * @test
     * @loadFixture testToHtmlDisabled
     */
    public function testToHtmlDisabled()
    {
        $this->assertNotContains('_anonymizeIp', $this->_block->toHtml());
    }
}
