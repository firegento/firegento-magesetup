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
 * @since     0.1.0
 */

/**
 * Adminhtml Controller for dislaying a form for some actions
 *
 * @category FireGento
 * @package  FireGento_MageSetup
 * @author   FireGento Team <team@firegento.com>
 */
class FireGento_MageSetup_FrontendController extends Mage_Core_Controller_Front_Action
{
    /**
     * Shows the given agreement
     */
    public function agreementsAction()
    {
        $this->loadLayout();
        if ($id = $this->getRequest()->getParam('id')) {
            /* @var $processor Mage_Cms_Model_Template_Filter */
            $processor = Mage::getModel('cms/template_filter');

            /* @var $agreement Mage_Checkout_Model_Agreement */
            $agreement = Mage::getModel('checkout/agreement')->load($id);

            $headBlock = $this->getLayout()->getBlock('head');
            $headBlock->setTitle(
                $headBlock->escapeHtml($processor->filter($agreement->getCheckboxText()))
            );

            $agreementText = $agreement->getContent();
            if (!$agreement->getIsHtml()) {
                $agreementText = $headBlock->escapeHtml($agreementText);
            }

            $agreeBlock = $this->getLayout()->getBlock('agreement');
            $agreeBlock->setText($processor->filter($agreementText));
        }
        $this->renderLayout();
    }
}
