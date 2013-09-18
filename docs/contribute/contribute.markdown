FireGento_MageSetup - Contribute
=====================
You would like to contribute to MageSetup by adding a new country. Thank you very much!
Here you'll find information about how to add a new country to this module.

##Small introduction
**What does MageSetup do?**
MageSetup helps you to setup your Magento-Shop at the very beginning to get correct taxes, email templates, payment
agreements, cms pages, etc. according to the country which you want to sell your products in.

##General settings
First of all, you have to add your country to the file config.xml (app/code/community/FireGento/MageSetup/etc/config.xml).
In config->global->available_countries you just add your country, by making a self closing tag with the iso2 code of your country.
![General Settings in config.xml](https://raw.github.com/firegento/firegento-magesetup/development/docs/contribute/images/countries.png "config.xml")

After that, add a folder here: app/code/community/FireGento/MageSetup/etc/
The name should be the iso2 code of your country too.

This newly created folder may contain up to 5 xml files:

- systemconfig.xml
- tax.xml
- cms.xml
- agreement.xml
- email.xml

You can take the default files from the folder app/code/community/FireGento/MageSetup/etc/default/. 
If any of these 5 files does not exist, it falls back to the default folder. 
Usually, having a tax.xml and in many cases an email.xml is sufficient.

##Setting up the agreements
If you have special billing agreements or likewise in your country, you need to copy the file agreements.xml 
from the default folder.
After that change the agreements.xml the way you need it.

##Setting up the cms pages
- If special cms pages are needed in your country, copy it from the default folder and change the cms.xml the way you need it.
Here is an example of a node for a cms page with an explanation of the tags.
![General Settings for cms pages](https://raw.github.com/firegento/firegento-magesetup/development/docs/contribute/images/cms-pages.png "cms pages")

<pre>
    * magesetup_404 -> this is the general identifier. Don't change this!
    * execute -> enter "1" here if the page should be created
    * filename -> the path to template file in app/locale/xx_YY/template/magesetup/page/
    * footerlink -> if a footer link is added or not. (see below for more information about it)
</pre>

**What is the footer link for?**

If the footer link is set, the cms page will be shown as a link on the footer menu in the block footer_links.

##Setting up the email templates
- The email templates depend on the localization of your country.
If you need to change it, just copy the email.xml from default folder and change the way you need it.
Here is an example of a node for an email template with an explanation of the tags.
![General Settings for email templates](https://raw.github.com/firegento/firegento-magesetup/development/docs/contribute/images/email-template.png "email template")

<pre>
    * admin_password_new -> the identifier of the mail template - don't change this
    * execute -> put "1" here if mail template should be installed
    * template_code -> that's the heading of the mail template in backend
    * template_type -> that's the type of the template: 1 stands for text, 2 stands for html
    * template_file -> the name of the template file (should be located in app/locale/xx_YY/template/email/ and contained in the language pack of your language)
    * config_data_path -> the configuration path to template, don't change this.
    * add_footer -> if a footer is added or not. (see below for more information about it)
    * add_business_terms -> if business terms are added or not. (see below for more information about it)
    * add_revocation -> if revocations are added or not. (see below for more information about it)
</pre>

**What is the add_footer tag for?**

If the footer link is set, the mail templates will get a footer with shop data at the bottom of the template.

**What is the add_business_terms tag for?**

If the business terms tag is set, the mail template will include the business terms from the shop.

**What is the add_revocation tag for?**

If the add_revocation tag is set, the mail template will include the revocations from the shop.

##Setting up the system configuration
If you need to change some configuration settings, just copy the systemconfig.xml from default and change the way you need it.
![Settings for system configuration](https://raw.github.com/firegento/firegento-magesetup/development/docs/contribute/images/system-config.png "system configuration")

<pre>
customer__create_account__confirm -> This is the path to the backend configuration in "Customer -> Create Account -> Confirm"
</pre>
If you want to add other settings, just apply to the way it's shown here.

##Setting up the taxes
Taxes are a bit tricky, because it's different all over the world.

* If it's an eu country and there are two tax rates, than copy the tax.xml from the folder **uk** (folder gb).
* If it's an eu country and there are three tax rates, than copy the tax.xml from the folder **fr**.
* If it's an non eu country and there are two tax rates, than copy the tax.xml from the folder **ch**.
* If it's an non eu country and there is no real tax at all, than copy the tax.xml from the folder **br** (in development).

After that, you can adjust the settings. Please try to change only the text fields and the percentages of the tax calculation rates.

##Setting up translation files, mail templates and agreements
To setup all translations for mail templates and so on, you need to create a new subfolder in app/locale.
Copy the en_US folder and give it the corresponding name for your language.
After that you need to do the hard work and translate the text parts of every file by hand.

This step is only needed for new languages which were not supported before.