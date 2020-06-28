FireGento_MageSetup
<!-- ALL-CONTRIBUTORS-BADGE:START - Do not remove or modify this section -->
[![All Contributors](https://img.shields.io/badge/all_contributors-11-orange.svg?style=flat-square)](#contributors-)
<!-- ALL-CONTRIBUTORS-BADGE:END -->
===================
MageSetup configures a shop for a national market. It's the international variant and successor of [GermanSetup](https://github.com/firegento/firegento-germansetup).

Currently supported countries: Austria, France, Germany, Italy, Russia, Switzerland, United Kingdom. More to follow.

Build Status
------------
* Latest Release: [![Master Branch](https://travis-ci.org/firegento/firegento-magesetup.png?branch=master)](https://travis-ci.org/firegento/firegento-magesetup)
* Development Branch: [![Development Branch](https://travis-ci.org/firegento/firegento-magesetup.png?branch=development)](https://travis-ci.org/firegento/firegento-magesetup)

Facts
-----
- Version: check [config.xml](https://github.com/firegento/firegento-magesetup/blob/master/src/app/code/community/FireGento/MageSetup/etc/config.xml)
- Extension key: FireGento_MageSetup
- [Extension on GitHub](https://github.com/firegento/firegento-magesetup/)
- Composer name: `firegento/magesetup` on [packages.firegento.com](http://packages.firegento.com/)

Description
-----------
Central features of MageSetup are:

* Setting of important configuration settings
* Predefined tax settings and tax classes for shipping from several countries to worldwide destinations
* Assign new tax classes to all products (configurable)
* Creation of email templates based on the local language pack. Legal texts can be added to some templates automatically.
* Creation and Activation of Checkout Agreements. Agreements can be shown at customer registration instead of or additional to the checkout. They can be required or not.
* Creation of default CMS pages like imprint, terms and conditions, privacy, shipping, payment methods.
* Create email templates, cms pages and blocks as well as checkout agreements for store views with a different language as well
* Possibility to add tax and/or shipping info to all prices
* Automatical generation of meta data to products
* Saving of every status change of newsletter subscriptions
* Presets are configurable via xml files for every country seperately
* Many more, see the [full list of features](https://github.com/firegento/firegento-magesetup/blob/development/docs/features/features.md) including several screenshots.

Requirements
------------
- PHP >= 5.3.0

Compatibility
-------------
- Magento >= 1.6

Installation
------------
Please create the desired websites and store views as well as install any language packs before running MageSetup.

Copy all files from the src/ folder to your magento directory in order to install the MageSetup module.
After you have installed the module, you should clear the cache and log off from admin panel. When you log on again, you should see the following hint:

    MageSetup has been installed. Click here to set up your pages, blocks, emails and tax settings.

If you don't see that hint, please check that the configuration setting **System -> Configuration -> Developer -> Template Settings -> Allow Symlinks** is enabled.

On the linked page, you can make the desired settings and then click "Run MageSetup" on the top or bottom right. The adjustments will be made.

Support
-------
If you encounter any problems or bugs, please create an issue on [GitHub](https://github.com/firegento/firegento-magesetup/issues).

Contribution
------------
Any contribution to the development of MageSetup is highly welcome. The best possibility to provide any code is to open a [pull request on GitHub](https://help.github.com/articles/using-pull-requests).

Please also see have a look at our [contribution guide](https://github.com/firegento/firegento-magesetup/blob/development/docs/contribute/contribute.md) for this extension and our [general contribution process](https://github.com/firegento/coding-guidelines/blob/master/guidelines/05_CONTRIBUTIONS.md) for FireGento extensions.

Developer
---------
FireGento Team
* Website: [http://firegento.com](http://firegento.com)
* Twitter: [@firegento](https://twitter.com/firegento)

Licence
-------
[GNU General Public License, version 3 (GPLv3)](http://opensource.org/licenses/gpl-3.0)

Copyright
---------
(c) 2013-2015 FireGento Team

## Contributors ✨

Thanks goes to these wonderful people ([emoji key](https://allcontributors.org/docs/en/emoji-key)):

<!-- ALL-CONTRIBUTORS-LIST:START - Do not remove or modify this section -->
<!-- prettier-ignore-start -->
<!-- markdownlint-disable -->
<table>
  <tr>
    <td align="center"><a href="http://www.integer-net.de/agentur/andreas-von-studnitz/"><img src="https://avatars1.githubusercontent.com/u/662059?v=4" width="100px;" alt=""/><br /><sub><b>Andreas von Studnitz</b></sub></a><br /><a href="https://github.com/firegento/firegento-magesetup/commits?author=avstudnitz" title="Code">💻</a></td>
    <td align="center"><a href="https://rouven.io/"><img src="https://avatars3.githubusercontent.com/u/393419?v=4" width="100px;" alt=""/><br /><sub><b>Rouven Alexander Rieker</b></sub></a><br /><a href="https://github.com/firegento/firegento-magesetup/commits?author=therouv" title="Code">💻</a></td>
    <td align="center"><a href="http://www.riconeitzel.de/"><img src="https://avatars2.githubusercontent.com/u/930706?v=4" width="100px;" alt=""/><br /><sub><b>Rico Neitzel</b></sub></a><br /><a href="https://github.com/firegento/firegento-magesetup/commits?author=riconeitzel" title="Code">💻</a></td>
    <td align="center"><a href="https://www.diglin.com/"><img src="https://avatars2.githubusercontent.com/u/1337461?v=4" width="100px;" alt=""/><br /><sub><b>Sylvain Rayé</b></sub></a><br /><a href="https://github.com/firegento/firegento-magesetup/commits?author=sylvainraye" title="Code">💻</a></td>
    <td align="center"><a href="https://www.simonsprankel.com/"><img src="https://avatars1.githubusercontent.com/u/930199?v=4" width="100px;" alt=""/><br /><sub><b>Simon Sprankel</b></sub></a><br /><a href="https://github.com/firegento/firegento-magesetup/commits?author=sprankhub" title="Code">💻</a></td>
    <td align="center"><a href="http://www.mage-profis.de/"><img src="https://avatars0.githubusercontent.com/u/710748?v=4" width="100px;" alt=""/><br /><sub><b>Mathis Klooß</b></sub></a><br /><a href="https://github.com/firegento/firegento-magesetup/commits?author=mklooss" title="Code">💻</a></td>
    <td align="center"><a href="http://www.fabian-blechschmidt.de/"><img src="https://avatars1.githubusercontent.com/u/379680?v=4" width="100px;" alt=""/><br /><sub><b>Fabian Blechschmidt</b></sub></a><br /><a href="https://github.com/firegento/firegento-magesetup/commits?author=Schrank" title="Code">💻</a></td>
  </tr>
  <tr>
    <td align="center"><a href="https://magento.stackexchange.com/users/46249/sv3n"><img src="https://avatars1.githubusercontent.com/u/5022236?v=4" width="100px;" alt=""/><br /><sub><b>sv3n</b></sub></a><br /><a href="https://github.com/firegento/firegento-magesetup/commits?author=sreichel" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/cphilipp"><img src="https://avatars1.githubusercontent.com/u/2188398?v=4" width="100px;" alt=""/><br /><sub><b>Christian Philipp</b></sub></a><br /><a href="https://github.com/firegento/firegento-magesetup/commits?author=cphilipp" title="Code">💻</a></td>
    <td align="center"><a href="http://www.webguys.de/"><img src="https://avatars1.githubusercontent.com/u/940631?v=4" width="100px;" alt=""/><br /><sub><b>Tobias Vogt</b></sub></a><br /><a href="https://github.com/firegento/firegento-magesetup/commits?author=tobi-pb" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/winkelsdorf"><img src="https://avatars0.githubusercontent.com/u/1413291?v=4" width="100px;" alt=""/><br /><sub><b>Frederik Winkelsdorf</b></sub></a><br /><a href="https://github.com/firegento/firegento-magesetup/commits?author=winkelsdorf" title="Code">💻</a></td>
  </tr>
</table>

<!-- markdownlint-enable -->
<!-- prettier-ignore-end -->
<!-- ALL-CONTRIBUTORS-LIST:END -->

This project follows the [all-contributors](https://github.com/all-contributors/all-contributors) specification. Contributions of any kind welcome!