FireGento_MageSetup - Features
=====================
##Contents
- [Setup features](#setup-features)
- [Backend features](#backend-features)
- [Frontend features](#frontend-features)

## <a id="setup"></a>Setup Features
### General
- Display a hint to fill out configuration form after first login  
![Hint after Installation](https://raw.github.com/firegento/firegento-magesetup/development/docs/features/images/install-hint.png "Hint after Installation")
- Supports the following countries right now:
    * Austria
    * France
    * Germany
    * Italy
    * Russia
    * Switzerland
    * United Kingdom
- **Important:** After form submission, the form still displays the default values. The settings have been changed though     
    
### Configuration Setup
![Configuration Setup](https://raw.github.com/firegento/firegento-magesetup/development/docs/features/images/setup-configuration.png "Configuration Setup")

- Choose a country which will be configured as shipping source
- Set country specific configuration settings (i.e. newsletter confirmation

### Tax Setup
![Tax Setup](https://raw.github.com/firegento/firegento-magesetup/development/docs/features/images/setup-tax.png "Tax Setup")

- Tax settings for the selected country (see **Configuration Setup**) 
- All tax classes, rates and rules are deleted in the process and new ones are created
- For EU countries, shipping to all EU countries is supported
- You can select new tax classes for your products (if you have any yet) and customer groups depending on the old tax classes

### CMS Setup
![CMS Setup](https://raw.github.com/firegento/firegento-magesetup/development/docs/features/images/setup-cms.png "CMS Setup")

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

### Email Setup
![Email Setup](https://raw.github.com/firegento/firegento-magesetup/development/docs/features/images/setup-email.png "Email Setup")
  
- Setup Emails 
    * Choose a different language for every store view 
    * Emails are taken from installed language packs
    * All emails are created as transational emails and can thus be edited in the Magento admin panel
    * Some blocks are added automatically to certain emails (mostly "New Order" and "New customer"):
        - Store information (template can be found at **/app/design/frontend/base/default/template/magesetup/imprint/email_footer.phtml**)
        - Business terms (taken from created static block)
        - Declaration of Revocation (taken from created static block)
        
## Backend Features    
### New configuration fields for shop information (imprint)
- Can be found in **System -> Configuration -> General -> Imprint**
- Displays entered information in cms page "imprint" and in email footer
    
### Checkout Agreements
- Option to display checkout agreements on checkout, and customer registration, on both or none
- Option to make checkout agreements required (display checkbox on frontend) or optional (does not display checkbox, just the test)  
![Checkout Agreements](https://raw.github.com/firegento/firegento-magesetup/development/docs/features/images/checkout-agreements.png "Checkout Agreements")

### Newsletter Subscribers Status History
- Store all newsletter subscription statusses of all subscribers
- Document all status changes in order to be able to prove subscriptions and unsubscriptions   
![Newsletter History](https://raw.github.com/firegento/firegento-magesetup/development/docs/features/images/newsletter-history.png "Newsletter History")

### Auto-generate meta data for products
- Generate meta title from product name
- Generate meta keywords from category names
- Generate meta description from short description, (if empty) description or (if still empty) category names  
![Product Meta Data Generation](https://raw.github.com/firegento/firegento-magesetup/development/docs/features/images/product-meta-autogenerate.png "Product Meta Data Generation")

## Frontend Features
### Info Block below Prices
- Display a block below prices on product list and product view pages  
![Block on product view page](https://raw.github.com/firegento/firegento-magesetup/development/docs/features/images/price-text-view.png "Block on product view page")
- Configure via backend in **System -> Configuration -> Catalog -> Price**  
![Price configuration](https://raw.github.com/firegento/firegento-magesetup/development/docs/features/images/price-configuration.png "Price configuration")

### Display additional attributes in cart and on checkout review page
- Can be selected by attribute in **Catalog -> Attributes -> Manage Attributes**  
![Attribute management](https://raw.github.com/firegento/firegento-magesetup/development/docs/features/images/attribute-display-checkout.png "Attribute management")  
![Additional attribute in cart](https://raw.github.com/firegento/firegento-magesetup/development/docs/features/images/attribute-display-checkout-cart.png "Additional attribute in cart")  

### Shipping Costs block on cart page
- Block can be replaced with a simple link to the shipping costs cms page  
![Shipping costs in cart](https://raw.github.com/firegento/firegento-magesetup/development/docs/features/images/cart-shipping-costs.png "Shipping costs in cart")
- Can be configured in **System -> Configuration -> Checkout -> Shopping cart -> Hide estimated shipping costs in cart**

### Redesign Checkout review page
- ![Checkout review page](https://raw.github.com/firegento/firegento-magesetup/development/docs/features/images/checkout-review.png "Checkout review page")  
   Regrouping for better overview and due to legal issues
- Display additional text (can be configured in **System -> Configuration -> Checkout -> Checkout Options -> Display Additional Information**)  

### Dynamic Shipping Tax Class Calculation
- Calculate shipping tax class depending on products in cart
    * Use highest product tax class as shipping tax class
    * Or use the tax rate of products that make up the biggest amount  
![Shipping tax class](https://raw.github.com/firegento/firegento-magesetup/development/docs/features/images/shipping-tax-class.png "Shipping tax class")