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
 * @since     1.1.4
 */
/**
 * Newsletter Subscriber Status Grid
 *
 * @category  FireGento
 * @package   FireGento_GermanSetup
 * @author    FireGento Team <team@firegento.com>
 * @copyright 2012 FireGento Team (http://www.firegento.de). All rights served.
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License, version 3 (GPLv3)
 * @version   $Id:$
 * @since     1.1.4
 */
class FireGento_GermanSetup_Block_Adminhtml_Newsletter_Subscriber_Status_Grid
    extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Class constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('subscriberStatusGrid');
        $this->setDefaultSort('created_at');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * Prepares the grid collection
     *
     * @see Mage_Adminhtml_Block_Widget_Grid::_prepareCollection()
     * @return FireGento_GermanSetup_Block_Adminhtml_Newsletter_Subscriber_Status_Grid
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel('germansetup/newsletter_subscriber_status_collection');
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * Prepares the grid columns
     *
     * @see Mage_Adminhtml_Block_Widget_Grid::_prepareColumns()
     * @return FireGento_GermanSetup_Block_Adminhtml_Newsletter_Subscriber_Status_Grid
     */
    protected function _prepareColumns()
    {
        $this->addColumn('subscriber', array(
            'header'    => Mage::helper('newsletter')->__('ID'),
            'index'     => 'subscriber',
            'type'      => 'int',
            'width'     => '75px'
        ));

        $this->addColumn('email', array(
            'header'    => Mage::helper('newsletter')->__('Email'),
            'index'     => 'email'
        ));

        $this->addColumn('status', array(
            'header'    => Mage::helper('newsletter')->__('Status'),
            'index'     => 'status',
            'width'     => '150px',
            'type'      => 'options',
            'options'   => array(
                Mage_Newsletter_Model_Subscriber::STATUS_NOT_ACTIVE => Mage::helper('newsletter')->__('Not Activated'),
                Mage_Newsletter_Model_Subscriber::STATUS_SUBSCRIBED => Mage::helper('newsletter')->__('Subscribed'),
                Mage_Newsletter_Model_Subscriber::STATUS_UNSUBSCRIBED => Mage::helper('newsletter')->__('Unsubscribed'),
                Mage_Newsletter_Model_Subscriber::STATUS_UNCONFIRMED => Mage::helper('newsletter')->__('Unconfirmed'),
            )
        ));

        $this->addColumn('created_at', array(
            'header'    => Mage::helper('adminhtml')->__('Created At'),
            'index'     => 'created_at',
            'type'      => 'datetime',
            'width'     => '150px'
        ));

        return parent::_prepareColumns();
    }

    /**
     * Retrieve the grid url for ajax reloads
     *
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=> true));
    }

    /**
     * Deactivate the grid row url
     *
     * @see Mage_Adminhtml_Block_Widget_Grid::getRowUrl()
     * @return boolean
     */
    public function getRowUrl($row)
    {
        return false;
    }
}
