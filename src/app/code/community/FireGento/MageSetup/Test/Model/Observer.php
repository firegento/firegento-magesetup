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
class FireGento_MageSetup_Test_Model_Observer extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @var FireGento_MageSetup_Model_Observer
     */
    protected $_model;

    /**
     * Set up test class
     */
    protected function setUp()
    {
        parent::setUp();

        $this->_model = Mage::getModel('magesetup/observer');
    }

    /**
     * @test
     */
    public function testInstance()
    {
        $this->assertInstanceOf('FireGento_MageSetup_Model_Observer', $this->_model);
    }

    /**
     * @test
     * @loadFixture testGoogleAnonymizationEnabled
     */
    public function testGoogleAnonymizationEnabled()
    {
        $block = self::app()->getLayout()->createBlock('googleanalytics/ga')->setTemplate('googleanalytics/ga.phtml');
        $transport = new Varien_Object();
        $transport->setHtml($block->toHtml());

        $event = new Varien_Event();
        $event->setData('block', $block);
        $event->setData('transport', $transport);
        $observer = new Varien_Event_Observer();
        $observer->setEvent($event);

        $this->_model->setGAAnonymizerCode($observer);

        $this->assertContains('_anonymizeIp', $observer->getEvent()->getTransport()->getHtml());
    }

    /**
     * @test
     * @loadFixture testGoogleAnonymizationDisabled
     */
    public function testGoogleAnonymizationDisabled()
    {
        $block = $this->app()->getLayout()->createBlock('googleanalytics/ga')->setTemplate('googleanalytics/ga.phtml');
        $transport = new Varien_Object();
        $transport->setHtml($block->toHtml());

        $event = new Varien_Event();
        $event->setData('block', $block);
        $event->setData('transport', $transport);
        $observer = new Varien_Event_Observer();
        $observer->setEvent($event);

        $this->_model->setGAAnonymizerCode($observer);

        $this->assertNotContains('_anonymizeIp', $observer->getEvent()->getTransport()->getHtml());
    }
}
