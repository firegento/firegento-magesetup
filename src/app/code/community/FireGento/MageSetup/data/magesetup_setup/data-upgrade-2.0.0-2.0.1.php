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
 * @since     2.0.1
 */
/**
 * Data upgrade script; Adds Italian region support to Magento ecosystem
 *
 * @category FireGento
 * @package  FireGento_MageSetup
 * @author   FireGento Team <team@firegento.com>
 */

/* @var $this Mage_Eav_Model_Entity_Setup */
$installer = $this;

$data = array(
    'AG' => 'Agrigento',
    'AL' => 'Alessandria',
    'AN' => 'Ancona',
    'AO' => 'Aosta',
    'AR' => 'Arezzo',
    'AP' => 'Ascoli Piceno',
    'AT' => 'Asti',
    'AV' => 'Avellino',
    'BA' => 'Bari',
    'BT' => 'Barletta-Andria-Trani',
    'BL' => 'Belluno',
    'BN' => 'Benevento',
    'BG' => 'Bergamo',
    'BI' => 'Biella',
    'BO' => 'Bologna',
    'BZ' => 'Bolzano',
    'BS' => 'Brescia',
    'BR' => 'Brindisi',
    'CA' => 'Cagliari',
    'CL' => 'Caltanissetta',
    'CB' => 'Campobasso',
    'CI' => 'Carbonia-Iglesias',
    'CE' => 'Caserta',
    'CT' => 'Catania',
    'CZ' => 'Catanzaro',
    'CH' => 'Chieti',
    'CO' => 'Como',
    'CS' => 'Cosenza',
    'CR' => 'Cremona',
    'KR' => 'Crotone',
    'CN' => 'Cuneo',
    'EN' => 'Enna',
    'FM' => 'Fermo',
    'FE' => 'Ferrara',
    'FI' => 'Firenze',
    'FG' => 'Foggia',
    'FC' => 'Forlì-Cesena',
    'FR' => 'Frosinone',
    'GE' => 'Genova',
    'GO' => 'Gorizia',
    'GR' => 'Grosseto',
    'IM' => 'Imperia',
    'IS' => 'Isernia',
    'SP' => 'La Spezia',
    'AQ' => 'L\'Aquila',
    'LT' => 'Latina',
    'LE' => 'Lecce',
    'LC' => 'Lecco',
    'LI' => 'Livorno',
    'LO' => 'Lodi',
    'LU' => 'Lucca',
    'MC' => 'Macerata',
    'MN' => 'Mantova',
    'MS' => 'Massa-Carrara',
    'MT' => 'Matera',
    'ME' => 'Messina',
    'MI' => 'Milano',
    'MO' => 'Modena',
    'MB' => 'Monza e Brianza',
    'NA' => 'Napoli',
    'NO' => 'Novara',
    'NU' => 'Nuoro',
    'OT' => 'Olbia-Tempio',
    'OR' => 'Oristano',
    'PD' => 'Padova',
    'PA' => 'Palermo',
    'PR' => 'Parma',
    'PV' => 'Pavia',
    'PG' => 'Perugia',
    'PU' => 'Pesaro e Urbino',
    'PE' => 'Pescara',
    'PC' => 'Piacenza',
    'PI' => 'Pisa',
    'PT' => 'Pistoia',
    'PN' => 'Pordenone',
    'PZ' => 'Potenza',
    'PO' => 'Prato',
    'RG' => 'Ragusa',
    'RA' => 'Ravenna',
    'RC' => 'Reggio Calabria',
    'RE' => 'Reggio Emilia',
    'RI' => 'Rieti',
    'RN' => 'Rimini',
    'RM' => 'Roma',
    'RO' => 'Rovigo',
    'SA' => 'Salerno',
    'VS' => 'Medio Campidano',
    'SS' => 'Sassari',
    'SV' => 'Savona',
    'SI' => 'Siena',
    'SR' => 'Siracusa',
    'SO' => 'Sondrio',
    'TA' => 'Taranto',
    'TE' => 'Teramo',
    'TR' => 'Terni',
    'TO' => 'Torino',
    'OG' => 'Ogliastra',
    'TP' => 'Trapani',
    'TN' => 'Trento',
    'TV' => 'Treviso',
    'TS' => 'Trieste',
    'UD' => 'Udine',
    'VA' => 'Varese',
    'VE' => 'Venezia',
    'VB' => 'Verbano-Cusio-Ossola',
    'VC' => 'Vercelli',
    'VR' => 'Verona',
    'VV' => 'Vibo Valentia',
    'VI' => 'Vicenza',
    'VT' => 'Viterbo',
);

/* @var $region Mage_Directory_Model_Region */
$region = Mage::getModel('directory/region');

$regionTable = $installer->getTable('directory/country_region');
$regionNameTable = $installer->getTable('directory/country_region_name');

foreach ($data as $code => $name) {
    $region->loadByCode($code, 'IT');
    if ($region->getId()) {
        continue;
    }

    $bind = array(
        'country_id' => 'IT',
        'code' => $code,
        'default_name' => $name,
    );
    $installer->getConnection()->insert($regionTable, $bind);
    $regionId = $installer->getConnection()->lastInsertId($regionTable);

    $bind = array(
        'locale' => 'en_US',
        'region_id' => $regionId,
        'name' => $name,
    );
    $installer->getConnection()->insert($regionNameTable, $bind);
}
