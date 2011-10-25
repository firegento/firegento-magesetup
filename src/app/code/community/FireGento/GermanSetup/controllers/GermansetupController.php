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
 * Adminhtml Controller for dislaying a form for some actions
 *
 * @category  FireGento
 * @package   FireGento_GermanSetup
 * @author    FireGento Team <team@firegento.com>
 * @copyright 2011 FireGento Team (http://www.firegento.de). All rights served.
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License, version 3 (GPLv3)
 * @version   $Id:$
 * @since     0.4.0
 */
class FireGento_GermanSetup_GermansetupController extends Mage_Adminhtml_Controller_Action
{
    /**
      * Basic action: external sale form
      */
    public function indexAction()
    {
        $this->_initLayoutMessages('adminhtml/session');
        
        $this->loadLayout()
			->_setActiveMenu('system/germansetup')
			->_addBreadcrumb(Mage::helper('germansetup')->__('German Setup'), Mage::helper('germansetup')->__('German Setup'))

            ->_addContent($this->getLayout()->createBlock('germansetup/adminhtml_germansetup'))
			->renderLayout();
    }
    
    /**
      * Basic action: external sale save action
      */
    public function saveAction() {

        //Mage::log('$this->getRequest()->getParams()');
        //Mage::log($this->getRequest()->getParams());

        /** @todo make post requests work */
        //if ($this->getRequest()->isPost()) {

            if ($this->getRequest()->getParam('cms') == 1) {

                Mage::getSingleton('germansetup/setup_cms')->setup();
                $this->_getSession()->addSuccess($this->__('CMS Blocks and Pages have been created.'));
            }

        //}

        $this->_redirect('*/*/');
    }
}
