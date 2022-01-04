<!-- ALL-CONTRIBUTORS-BADGE:START - Do not remove or modify this section -->
[![All Contributors](https://img.shields.io/badge/all_contributors-39-orange.svg?style=flat-square)](#contributors-)
<!-- ALL-CONTRIBUTORS-BADGE:END -->
# FireGento_MageSetup

MageSetup configures a shop for a national market. It's the international variant and successor of [GermanSetup](https://github.com/firegento/firegento-germansetup).

Currently supported countries: Austria, France, Germany, Italy, Russia, Switzerland, United Kingdom. More to follow.

## Build Status

* Latest Release: [![Master Branch](https://travis-ci.org/firegento/firegento-magesetup.png?branch=master)](https://travis-ci.org/firegento/firegento-magesetup)
* Development Branch: [![Development Branch](https://travis-ci.org/firegento/firegento-magesetup.png?branch=development)](https://travis-ci.org/firegento/firegento-magesetup)

## Facts

- Version: check [config.xml](https://github.com/firegento/firegento-magesetup/blob/master/src/app/code/community/FireGento/MageSetup/etc/config.xml)
- Extension key: FireGento_MageSetup
- [Extension on GitHub](https://github.com/firegento/firegento-magesetup/)
- Composer name: `firegento/magesetup` on [packages.firegento.com](http://packages.firegento.com/)

## Description

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

## Requirements

- PHP >= 5.3.0

## Compatibility

- Magento >= 1.6

## Installation

Please create the desired websites and store views as well as install any language packs before running MageSetup.

Copy all files from the src/ folder to your magento directory in order to install the MageSetup module.
After you have installed the module, you should clear the cache and log off from admin panel. When you log on again, you should see the following hint:

    MageSetup has been installed. Click here to set up your pages, blocks, emails and tax settings.

If you don't see that hint, please check that the configuration setting **System -> Configuration -> Developer -> Template Settings -> Allow Symlinks** is enabled.

On the linked page, you can make the desired settings and then click "Run MageSetup" on the top or bottom right. The adjustments will be made.

## Support

If you encounter any problems or bugs, please create an issue on [GitHub](https://github.com/firegento/firegento-magesetup/issues).

## Contribution

Any contribution to the development of MageSetup is highly welcome. The best possibility to provide any code is to open a [pull request on GitHub](https://help.github.com/articles/using-pull-requests).

Please also see have a look at our [contribution guide](https://github.com/firegento/firegento-magesetup/blob/development/docs/contribute/contribute.md) for this extension and our [general contribution process](https://github.com/firegento/coding-guidelines/blob/master/guidelines/05_CONTRIBUTIONS.md) for FireGento extensions.

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
    <td align="center"><a href="https://twitter.com/sirawesome_"><img src="https://avatars3.githubusercontent.com/u/2085721?v=4" width="100px;" alt=""/><br /><sub><b>Julian</b></sub></a><br /><a href="https://github.com/firegento/firegento-magesetup/commits?author=jwittorf" title="Code">💻</a></td>
    <td align="center"><a href="http://www.multichannelsystems.com/"><img src="https://avatars3.githubusercontent.com/u/1866724?v=4" width="100px;" alt=""/><br /><sub><b>Martin Grossmann</b></sub></a><br /><a href="https://github.com/firegento/firegento-magesetup/commits?author=grossmann" title="Code">💻</a></td>
    <td align="center"><a href="https://www.gerhard-fobe.de/"><img src="https://avatars3.githubusercontent.com/u/1615283?v=4" width="100px;" alt=""/><br /><sub><b>Gerhard Fobe</b></sub></a><br /><a href="https://github.com/firegento/firegento-magesetup/commits?author=gfobe" title="Code">💻</a></td>
  </tr>
  <tr>
    <td align="center"><a href="http://twitter.com/benmarks"><img src="https://avatars1.githubusercontent.com/u/2141138?v=4" width="100px;" alt=""/><br /><sub><b>Ben Marks</b></sub></a><br /><a href="https://github.com/firegento/firegento-magesetup/commits?author=benmarks" title="Code">💻</a></td>
    <td align="center"><a href="https://www.paepper.com/"><img src="https://avatars0.githubusercontent.com/u/4135790?v=4" width="100px;" alt=""/><br /><sub><b>Marc Päpper</b></sub></a><br /><a href="https://github.com/firegento/firegento-magesetup/commits?author=mpaepper" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/kkrieger85"><img src="https://avatars2.githubusercontent.com/u/4435523?v=4" width="100px;" alt=""/><br /><sub><b>Kevin Krieger</b></sub></a><br /><a href="https://github.com/firegento/firegento-magesetup/commits?author=kkrieger85" title="Code">💻</a> <a href="https://github.com/firegento/firegento-magesetup/commits?author=kkrieger85" title="Documentation">📖</a></td>
    <td align="center"><a href="http://vinaikopp.com/"><img src="https://avatars0.githubusercontent.com/u/72463?v=4" width="100px;" alt=""/><br /><sub><b>Vinai Kopp</b></sub></a><br /><a href="https://github.com/firegento/firegento-magesetup/commits?author=Vinai" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/EliasKotlyar"><img src="https://avatars0.githubusercontent.com/u/9529505?v=4" width="100px;" alt=""/><br /><sub><b>Elias Kotlyar</b></sub></a><br /><a href="https://github.com/firegento/firegento-magesetup/commits?author=EliasKotlyar" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/tkn98"><img src="https://avatars2.githubusercontent.com/u/10513307?v=4" width="100px;" alt=""/><br /><sub><b>Tom Klingenberg</b></sub></a><br /><a href="https://github.com/firegento/firegento-magesetup/commits?author=tkn98" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/skrollme"><img src="https://avatars2.githubusercontent.com/u/1336659?v=4" width="100px;" alt=""/><br /><sub><b>Sebastian K</b></sub></a><br /><a href="https://github.com/firegento/firegento-magesetup/commits?author=skrollme" title="Code">💻</a></td>
  </tr>
  <tr>
    <td align="center"><a href="http://solidbox.de/"><img src="https://avatars1.githubusercontent.com/u/5131653?v=4" width="100px;" alt=""/><br /><sub><b>Michael Wagner</b></sub></a><br /><a href="https://github.com/firegento/firegento-magesetup/commits?author=rengaw83" title="Code">💻</a></td>
    <td align="center"><a href="https://wambo-agency.com/"><img src="https://avatars2.githubusercontent.com/u/98465?v=4" width="100px;" alt=""/><br /><sub><b>René Penner</b></sub></a><br /><a href="https://github.com/firegento/firegento-magesetup/commits?author=renepenner" title="Code">💻</a></td>
    <td align="center"><a href="https://www.openstream.ch/"><img src="https://avatars2.githubusercontent.com/u/58966?v=4" width="100px;" alt=""/><br /><sub><b>Nick Weisser</b></sub></a><br /><a href="https://github.com/firegento/firegento-magesetup/commits?author=nickw108" title="Code">💻</a></td>
    <td align="center"><a href="https://webvisum.de/"><img src="https://avatars2.githubusercontent.com/u/12797503?v=4" width="100px;" alt=""/><br /><sub><b>Andreas Mautz</b></sub></a><br /><a href="https://github.com/firegento/firegento-magesetup/commits?author=mautz-et-tong" title="Code">💻</a></td>
    <td align="center"><a href="http://www.magento-saigon.com/"><img src="https://avatars1.githubusercontent.com/u/261406?v=4" width="100px;" alt=""/><br /><sub><b>Matias Orlando</b></sub></a><br /><a href="https://github.com/firegento/firegento-magesetup/commits?author=matiaso" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/mam08ixo"><img src="https://avatars0.githubusercontent.com/u/1771622?v=4" width="100px;" alt=""/><br /><sub><b>Christoph Aßmann</b></sub></a><br /><a href="https://github.com/firegento/firegento-magesetup/commits?author=mam08ixo" title="Code">💻</a></td>
    <td align="center"><a href="https://mkleine.de/"><img src="https://avatars2.githubusercontent.com/u/1959049?v=4" width="100px;" alt=""/><br /><sub><b>Matthias Kleine</b></sub></a><br /><a href="https://github.com/firegento/firegento-magesetup/commits?author=klein0r" title="Code">💻</a></td>
  </tr>
  <tr>
    <td align="center"><a href="https://github.com/jg-development"><img src="https://avatars1.githubusercontent.com/u/6112739?v=4" width="100px;" alt=""/><br /><sub><b>Jan Gantzert</b></sub></a><br /><a href="https://github.com/firegento/firegento-magesetup/commits?author=jg-development" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/easyMaxi"><img src="https://avatars3.githubusercontent.com/u/965733?v=4" width="100px;" alt=""/><br /><sub><b>easyMaxi</b></sub></a><br /><a href="https://github.com/firegento/firegento-magesetup/commits?author=easyMaxi" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/dsdata"><img src="https://avatars3.githubusercontent.com/u/927446?v=4" width="100px;" alt=""/><br /><sub><b>Daniel Sasse</b></sub></a><br /><a href="https://github.com/firegento/firegento-magesetup/commits?author=dsdata" title="Code">💻</a></td>
    <td align="center"><a href="http://davidmanners.de/"><img src="https://avatars2.githubusercontent.com/u/1572836?v=4" width="100px;" alt=""/><br /><sub><b>David Manners</b></sub></a><br /><a href="https://github.com/firegento/firegento-magesetup/commits?author=dmanners" title="Code">💻</a></td>
    <td align="center"><a href="https://www.xing.com/profile/Daniel_Rose16"><img src="https://avatars1.githubusercontent.com/u/489806?v=4" width="100px;" alt=""/><br /><sub><b>Daniel Rose</b></sub></a><br /><a href="https://github.com/firegento/firegento-magesetup/commits?author=daniel-rose" title="Code">💻</a></td>
    <td align="center"><a href="http://www.christian-hinz.de/"><img src="https://avatars1.githubusercontent.com/u/12525017?v=4" width="100px;" alt=""/><br /><sub><b>Christian Hinz</b></sub></a><br /><a href="https://github.com/firegento/firegento-magesetup/commits?author=crysix" title="Code">💻</a></td>
    <td align="center"><a href="https://muench.dev/"><img src="https://avatars2.githubusercontent.com/u/211294?v=4" width="100px;" alt=""/><br /><sub><b>Christian Münch</b></sub></a><br /><a href="https://github.com/firegento/firegento-magesetup/commits?author=cmuench" title="Code">💻</a></td>
  </tr>
  <tr>
    <td align="center"><a href="https://github.com/ckressibucherTIM"><img src="https://avatars2.githubusercontent.com/u/3985914?v=4" width="100px;" alt=""/><br /><sub><b>ckressibucherTIM</b></sub></a><br /><a href="https://github.com/firegento/firegento-magesetup/commits?author=ckressibucherTIM" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/borriglione"><img src="https://avatars2.githubusercontent.com/u/465544?v=4" width="100px;" alt=""/><br /><sub><b>André Herrn</b></sub></a><br /><a href="https://github.com/firegento/firegento-magesetup/commits?author=borriglione" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/bastianccm"><img src="https://avatars1.githubusercontent.com/u/1145424?v=4" width="100px;" alt=""/><br /><sub><b>Bastian</b></sub></a><br /><a href="https://github.com/firegento/firegento-magesetup/commits?author=bastianccm" title="Code">💻</a></td>
    <td align="center"><a href="https://www.jumplink.eu/"><img src="https://avatars2.githubusercontent.com/u/1073989?v=4" width="100px;" alt=""/><br /><sub><b>Pascal Garber</b></sub></a><br /><a href="https://github.com/firegento/firegento-magesetup/commits?author=JumpLink" title="Code">💻</a></td>
  </tr>
</table>

<!-- markdownlint-enable -->
<!-- prettier-ignore-end -->
<!-- ALL-CONTRIBUTORS-LIST:END -->

This project follows the [all-contributors](https://github.com/all-contributors/all-contributors) specification. Contributions of any kind welcome!

## Developer

FireGento Team
* Website: [http://firegento.com](http://firegento.com)
* Twitter: [@firegento](https://twitter.com/firegento)

## Licence

[GNU General Public License, version 3 (GPLv3)](http://opensource.org/licenses/gpl-3.0)

## Copyright

(c) 2013-2020 FireGento Team
