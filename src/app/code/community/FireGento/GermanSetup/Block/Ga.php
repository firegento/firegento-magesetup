<?php
/**
 * This file is part of the FIREGENTO project.
 *
 * FireGento_GermanSetup is free software; you can redistribute it and/or
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
 * @package   FireGento_GermanSetup
 * @author    FireGento Team <team@firegento.com>
 * @copyright 2012 FireGento Team (http://www.firegento.de). All rights served.
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License, version 3 (GPLv3)
 * @version   $Id:$
 * @since     0.1.0
 */
/**
 * Block to enable ip anonymization for german tracking.
 *
 * @category  FireGento
 * @package   FireGento_GermanSetup
 * @author    FireGento Team <team@firegento.com>
 * @copyright 2012 FireGento Team (http://www.firegento.de). All rights served.
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License, version 3 (GPLv3)
 * @version   $Id:$
 * @since     0.1.0
 */
class FireGento_GermanSetup_Block_Ga extends Mage_GoogleAnalytics_Block_Ga
{
    const CONFIG_GOOGLE_ANALYTICS_IP_ANONYMIZATION = 'google/analytics/ip_anonymization';

    /**
     * Prepare and return block's html output
     *
     * @return string
     */
    protected function _toHtml()
    {
        $html = parent::_toHtml();
        if (!Mage::getStoreConfigFlag( self::CONFIG_GOOGLE_ANALYTICS_IP_ANONYMIZATION )) {
            return $html;
        }

        $matches = array();
        $setAccountExpression = '/_gaq\.push\(\[\'_setAccount\', \'[a-zA-Z0-9-_]+\'\]\);\n/';
        $append = '_gaq.push([\'_gat._anonymizeIp\']);';

        if (preg_match_all($setAccountExpression, $html, $matches) && count($matches) && count($matches[0])) {
            $html = preg_replace($setAccountExpression, $matches[0][0] . $append . "\n", $html);
        }

        return $html;
    }
}
