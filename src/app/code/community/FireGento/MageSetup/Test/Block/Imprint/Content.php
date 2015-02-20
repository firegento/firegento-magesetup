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
class FireGento_MageSetup_Test_Block_Imprint_Content extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @var FireGento_MageSetup_Block_Imprint_Content
     */
    protected $_block;

    /**
     * Set up test class
     */
    protected function setUp()
    {
        parent::setUp();
        $this->_block = $this->app()->getLayout()->createBlock('magesetup/imprint_content');
    }

    /**
     * @test
     */
    public function testInstance()
    {
        $this->assertInstanceOf('FireGento_MageSetup_Block_Imprint_Content', $this->_block);
    }

    /**
     * @test
     * @loadFixture generalImprint
     */
    public function testSetStoreId()
    {
        $this->_block->setStoreId(1);
        $this->assertEquals('DE', $this->_block->getData('country'));
    }

    /**
     * @test
     */
    public function testGetStoreIdWithoutOrder()
    {
        $this->assertNull($this->_block->getStoreId());
    }

    /**
     * @test
     * @loadFixture generalImprint
     * @dataProvider dataProvider
     * @loadExpectations
     */
    public function testGetWeb($checkForProtocol)
    {
        $this->assertEquals($this->expected('auto')->getResult(), $this->_block->getWeb($checkForProtocol));
    }

    /**
     * @test
     * @loadFixture generalImprint
     */
    public function testGetCountry()
    {
        $this->assertEquals('Germany', $this->_block->getCountry());
    }

    /**
     * @test
     * @loadFixture generalImprint
     * @dataProvider dataProvider
     * @loadExpectations
     */
    public function testGetEmail($antispam)
    {
        $this->assertEquals($this->expected('auto')->getResult(), $this->_block->getEmail($antispam));
    }

    /**
     * @test
     */
    public function testGetEmailJs()
    {
        $parts = array(
            'foo',
            'bar.com'
        );

        $expectedJs = <<<JS
<script>function toRecipient(){var m = 'foo';m += '@';m += 'bar.com';location.href= "mailto:"+m;}</script>
JS;
        $this->assertEquals(
            $expectedJs,
            $this->_block->getEmailJs($parts)
        );
    }
}
