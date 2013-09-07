<?php
/**
 * 
 * @author      diglin
 * @since       07.09.13 16:06
 * @category    Brillensuppe
 * @package     Brillensuppe_Import
 * @copyright   Copyright (c) 2011-2013 Diglin (http://www.diglin.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

// Script is thought for French and Italian countries (feel free to improve or adapt for other lands)

require_once ('../../../../../Mage.php');

// Need to add HR for Croatia manually - Magento Core Config is not up-to-date
$europeanCountries = Mage::getConfig()->getNode('general/country/eu_countries');

// Generate tax_calculation_rates

if ($argc == 0) {
    die('Usage is ');
}

