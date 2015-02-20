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
class FireGento_MageSetup_Test_Config_Main extends EcomDev_PHPUnit_Test_Case_Config
{
    /**
     * Check it the installed module has the correct module version
     */
    public function testModuleConfig()
    {
        $this->assertModuleVersionGreaterThanOrEquals($this->expected('module')->getVersion());
        $this->assertModuleCodePool($this->expected('module')->getCodePool());
    }

    /**
     * Check that GermanSetup is not active
     */
    public function testGermanSetupNotActive()
    {
        $this->assertModuleIsNotActive('', 'FireGento_GermanSetup');
    }

    /**
     * Check if the block aliases are returning the correct class names
     */
    public function testBlockAliases()
    {
        $this->assertBlockAlias('magesetup/adminhtml_newsletter_subscriber_status_grid', 'FireGento_MageSetup_Block_Adminhtml_Newsletter_Subscriber_Status_Grid');
        $this->assertBlockAlias('magesetup/adminhtml_newsletter_subscriber_status', 'FireGento_MageSetup_Block_Adminhtml_Newsletter_Subscriber_Status');
        $this->assertBlockAlias('magesetup/adminhtml_magesetup', 'FireGento_MageSetup_Block_Adminhtml_Magesetup');
        $this->assertBlockAlias('magesetup/adminhtml_notifications', 'FireGento_MageSetup_Block_Adminhtml_Notifications');

        $this->assertBlockAlias('magesetup/bundle_catalog_product_price_abstract', 'FireGento_MageSetup_Block_Bundle_Catalog_Product_Price_Abstract');
        $this->assertBlockAlias('magesetup/bundle_catalog_product_price', 'FireGento_MageSetup_Block_Bundle_Catalog_Product_Price');

        $this->assertBlockAlias('magesetup/catalog_product_price_abstract', 'FireGento_MageSetup_Block_Catalog_Product_Price_Abstract');
        $this->assertBlockAlias('magesetup/catalog_product_price', 'FireGento_MageSetup_Block_Catalog_Product_Price');

        $this->assertBlockAlias('magesetup/checkout_agreements', 'FireGento_MageSetup_Block_Checkout_Agreements');
        $this->assertBlockAlias('magesetup/checkout_information', 'FireGento_MageSetup_Block_Checkout_Information');

        $this->assertBlockAlias('magesetup/customer_account_agreements', 'FireGento_MageSetup_Block_Customer_Account_Agreements');

        $this->assertBlockAlias('magesetup/imprint_content', 'FireGento_MageSetup_Block_Imprint_Content');
        $this->assertBlockAlias('magesetup/imprint_field', 'FireGento_MageSetup_Block_Imprint_Field');
    }

    /**
     * Check if the helper aliases are returning the correct class names
     */
    public function testHelperAliases()
    {
        $this->assertHelperAlias('magesetup', 'FireGento_MageSetup_Helper_Data');
        $this->assertHelperAlias('magesetup/catalog_product_configuration', 'FireGento_MageSetup_Helper_Catalog_Product_Configuration');
        $this->assertHelperAlias('magesetup/checkout_data', 'FireGento_MageSetup_Helper_Checkout_Data');
    }

    /**
     * Check if the helper aliases are returning the correct class names
     */
    public function testModelAliases()
    {
        $this->assertModelAlias('magesetup/newsletter_subscriber_status', 'FireGento_MageSetup_Model_Newsletter_Subscriber_Status');
        $this->assertResourceModelAlias('magesetup/newsletter_subscriber_status', 'FireGento_MageSetup_Model_Resource_Newsletter_Subscriber_Status');
        $this->assertResourceModelAlias('magesetup/newsletter_subscriber_status_collection', 'FireGento_MageSetup_Model_Resource_Newsletter_Subscriber_Status_Collection');

        $this->assertModelAlias('magesetup/newsletter_observer', 'FireGento_MageSetup_Model_Newsletter_Observer');

        $this->assertModelAlias('magesetup/setup_abstract', 'FireGento_MageSetup_Model_Setup_Abstract');
        $this->assertModelAlias('magesetup/setup_agreements', 'FireGento_MageSetup_Model_Setup_Agreements');
        $this->assertModelAlias('magesetup/setup_cms', 'FireGento_MageSetup_Model_Setup_Cms');
        $this->assertModelAlias('magesetup/setup_email', 'FireGento_MageSetup_Model_Setup_Email');
        $this->assertModelAlias('magesetup/setup_systemconfig', 'FireGento_MageSetup_Model_Setup_Systemconfig');
        $this->assertModelAlias('magesetup/setup_tax', 'FireGento_MageSetup_Model_Setup_Tax');

        $this->assertModelAlias('magesetup/source_cms_block', 'FireGento_MageSetup_Model_Source_Cms_Block');
        $this->assertModelAlias('magesetup/source_cms_page', 'FireGento_MageSetup_Model_Source_Cms_Page');
        $this->assertModelAlias('magesetup/source_tax_dynamicType', 'FireGento_MageSetup_Model_Source_Tax_DynamicType');
        $this->assertModelAlias('magesetup/source_tax_newProductTaxClass', 'FireGento_MageSetup_Model_Source_Tax_NewProductTaxClass');
        $this->assertModelAlias('magesetup/source_tax_productTaxClass', 'FireGento_MageSetup_Model_Source_Tax_ProductTaxClass');
        $this->assertModelAlias('magesetup/source_agreementType', 'FireGento_MageSetup_Model_Source_AgreementType');


        $this->assertModelAlias('magesetup/config', 'FireGento_MageSetup_Model_Config');
        $this->assertModelAlias('magesetup/observer', 'FireGento_MageSetup_Model_Observer');
        $this->assertModelAlias('magesetup/setup', 'FireGento_MageSetup_Model_Setup');
    }

    /**
     * Check if the rewrites are returning the correct class names
     */
    public function testRewrites()
    {
        $this->assertHelperAlias('catalog/product_configuration', 'FireGento_MageSetup_Helper_Catalog_Product_Configuration');
        $this->assertHelperAlias('checkout/data', 'FireGento_MageSetup_Helper_Checkout_Data');

        $this->assertModelAlias('tax/config', 'FireGento_MageSetup_Model_Tax_Config');
    }

    /**
     * @test
     */
    public function testSetupResource()
    {
        $this->assertSetupResourceDefined('FireGento_MageSetup', 'magesetup_setup');
        $this->assertSetupResourceExists('FireGento_MageSetup', 'magesetup_setup');
    }

    /**
     * @test
     */
    public function testEventObserver()
    {
        // Global event observers
        $this->assertEventObserverDefined(
            'global',
            'catalog_product_save_before',
            'magesetup/observer',
            'autogenerateMetaInformation'
        );
        $this->assertEventObserverDefined(
            'global',
            'newsletter_subscriber_save_after',
            'magesetup/newsletter_observer',
            'saveSubscriberStatusHistory'
        );

        // Frontend event observers
        $this->assertEventObserverDefined(
            'frontend',
            'core_block_abstract_to_html_before',
            'magesetup/observer',
            'filterAgreements'
        );
        $this->assertEventObserverDefined(
            'frontend',
            'controller_action_predispatch_customer_account_createpost',
            'magesetup/observer',
            'customerCreatePreDispatch'
        );
        $this->assertEventObserverDefined(
            'frontend',
            'core_block_abstract_to_html_after',
            'magesetup/observer',
            'setGAAnonymizerCode'
        );

        // Adminhtml event observers
        $this->assertEventObserverDefined(
            'adminhtml',
            'adminhtml_catalog_product_attribute_edit_prepare_form',
            'magesetup/observer',
            'addIsVisibleOnCheckoutOption'
        );
        $this->assertEventObserverDefined(
            'adminhtml',
            'adminhtml_block_html_before',
            'magesetup/observer',
            'addOptionsForAgreements'
        );

    }
}
