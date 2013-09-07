FireGento_MageSetup - Features
=====================
General
-------
- Display a hint to fill out configuration form after first login  
![Hint after Installation](https://raw.github.com/firegento/firegento-magesetup/development/docs/features/images/install-hint.png "Hint after Installation")
- Supports the following countries right now:
    * Austria
    * France
    * Germany
    * Italy
    * Russia
    * Switzerland
    
Configuration Setup
-----
![Configuration Setup](https://raw.github.com/firegento/firegento-magesetup/tree/development/docs/features/images/setup-configuration.png "Configuration Setup")

- Choose a country which will be configured as shipping source
- Set country specific configuration settings (i.e. newsletter confirmation

Tax Setup
---------
![Tax Setup](https://raw.github.com/firegento/firegento-magesetup/tree/development/docs/features/images/setup-tax.png "Tax Setup")

- Tax settings for the selected country (see **Configuration Setup**) 
- All tax classes, rates and rules are deleted in the process and new ones are created
- For EU countries, shipping to all EU countries is supported
- You can select new tax classes for your products (if you have any yet) depending on the old product tax class

CMS Setup
---------
![CMS Setup](https://raw.github.com/firegento/firegento-magesetup/tree/development/docs/features/images/setup-cms.png "CMS Setup")

- Setup preconfigured, language dependant CMS pages:  
    * 404 error
    * Imprint
    * Payment Methods
    * Privacy
    * Shipping Methods
    * Order Overview
    * Business Terms
    * Declaration of Revocation  
- Setup CMS static blocks (preconfigured, language dependant):
    * Business Terms (is used by static page with same name, checkout agreement and as email content for some emails) 
    * Declaration of Revocation (is used by static page with same name, checkout agreement and as email content for some emails)
    * Footer Links (including links to above pages)
- Setup Checkout Agreements (preconfigured, language dependant)
    * Business Terms
    * Declaration of Revocation
    
You can choose a different language for every store view.

Email Setup
---------
![Email Setup](raw.https://github.com/firegento/firegento-magesetup/tree/development/docs/features/images/setup-email.png "Email Setup")
  
- Setup Emails 
    * Choose a different language for every store view 
    * Emails are taken from installed language packs
    * All emails are created as transational emails and can thus be edited in the Magento admin panel
    * Some blocks are added automatically to certain emails (mostly "New Order" and "New customer"):
        - Store information (template can be found at **/app/design/frontend/base/default/template/magesetup/imprint/email_footer.phtml**)
        - Business terms (taken from created static block)
        - Declaration of Revocation (taken from created static block)