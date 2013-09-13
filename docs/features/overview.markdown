FireGento_MageSetup - the fast way to setup your Magento store
====================================================
MageSetup is a **free community module** for Magento which simplifies the process to setup your Magento store. 
Its broad set of features makes the shops comply to most national laws.
It has evolved from **GermanSetup**, a module which has grown very famous in Germany, Austria and Switzerland. Germany is known to have very rigid laws which was the foremost reason to start this module. 

What does it do?
----------------
MageSetup provides a new backend form which allows you to make a few decisions, mainly which country you are shipping from and which language(s) you are using. When submitting the form, FireGento_MageSetup does the following:
  
* Setup **tax** configuration for worldwide shipping. It sets up all necessary **product** and **customer tax classes** as well as all tax rates and calculation rules. 
   In particular, the complicated rules for shipping from a EU country are supported, so end customers from another EU country got to pay taxes while companies with a VAT ID don't.
* Create a few **CMS pages** and **static blocks** like imprint, business terms or revocation. The contents of these blocks can be used for checkout agreements or in emails as well.
* Setup **email templates** which allows the admin to adjust the shop emails further. An email footer with shop data is added to all emails, and business terms and the declaration of revocation is added to some.
* Display tax and/or shipping info to all **prices**
* Automatical generation of **meta data** to products
* Saving of every **status change of newsletter subscriptions**

There are many more features. Please see the [full list of features](https://github.com/firegento/firegento-magesetup/blob/development/docs/features/features.markdown) for a list of all features with screeenshots.

Which countries does it support?
--------------------------------
At the moment of writing this post, we support the following countries:

* Austria
* France
* Germany
* Italy
* Russia
* Switzerland
* United Kingdom

However, it is quite simple to add your own country. We will post a small developers guide to do so soon. 

Requirements
-------------------------

### Store Views
Prepare your store views if you have a multi language store before to proceed.

### Language package
All necessary locale packages should be installed before to proceed the setup. For example, if you want to support German and French countries,
please install the locale de_DE and fr_FR. See [Magento Connect] (http://www.magentocommerce.com/magento-connect/customer-experience/internationalization-localization.html) to get the packages or install them thanks to composer and our [FireGento Module repository](http://packages.firegento.com/). With composer and our example, you should have to add the name "connect20/locale_mage_community_de_DE" and "connect20/locale_mage_community_fr_FR"


How to install FireGento_MageSetup?
-------------------------
The module can be installed via 

* MagentoConnect (link will follow)
* [GitHub](https://github.com/firegento/firegento-magesetup/)
* Composer (name "firegento/magesetup" if you are using the [FireGento Module repository](http://packages.firegento.com/) ).

When the module is installed, please clear the cache, logout and login again. You will see the following hint:  
![Hint after Installation](https://raw.github.com/firegento/firegento-magesetup/development/docs/features/images/install-hint.png "Hint after Installation")
Follow the link, fill out the form and submit in order to apply the settings.
![Setup Form](https://raw.github.com/firegento/firegento-magesetup/development/docs/features/images/setup-overview.png "Setup Form")

**Attention:** As stated in the setup form, all tax settings will be overwritten.

Who is behind FireGento_MageSetup?
----------------------------------
![FireGento Logo](http://www.avs-webentwicklung.de/fileadmin/images/FireGento.png "FireGento Logo")  
FireGento is a group of Magento developers, working as freelancers and in companies. Starting in 2011, we began developing free modules for the community. 
We don't have any commercial interests. We founded an association in 2013, based in Germany, in order to organize events like the [Magento Hackathons](http://www.mage-hackathon.de/) more easily.
GermanSetup was one of the first modules to be published, and is the most well known project up to now. It's widely used in Germany, Austria and Switzerland up to now. 
It was started at a small meeting of ~15 persons at the German North Sea coast, and since then, a lot of work has been done in the free time of a couple of developers at home, at work, at conferences and meetings. 
