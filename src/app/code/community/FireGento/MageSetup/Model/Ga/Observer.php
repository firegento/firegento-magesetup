<?php
/**
 * This file is part of the FIREGENTO project.
 *
 * FireGento_MageSetup is free software; you can redistribute it and/or
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
 * @copyright 2013 FireGento Team (http://www.firegento.de). All rights served.
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License, version 3 (GPLv3)
 * @version   $Id:$
 * @since     0.1.0
 */
/**
 * Event to enable ip anonymization for german tracking.
 *
 * @category  FireGento
 * @package   FireGento_MageSetup
 * @author    FireGento Team <team@firegento.com>
 * @copyright 2013 FireGento Team (http://www.firegento.de). All rights served.
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License, version 3 (GPLv3)
 * @version   $Id:$
 * @since     0.1.0
 */
class FireGento_MageSetup_Model_Ga_Observer
{
    const CONFIG_GOOGLE_ANALYTICS_IP_ANONYMIZATION = 'google/analytics/ip_anonymization';

    /**
     * Prepare and modify block's html output
     *
     * @return $this, via $this->getTransport()->getHtml() you get changed html
     */
    public function appendAccountInformation(Varien_Event_Observer $observer)
    {
        if (($block = $observer->getEvent()->getBlock()) instanceof Mage_GoogleAnalytics_Block_Ga) {
            $transport = $observer->getEvent()->getTransport();

            if (!$transport || !($html = $transport->getHtml()) || !Mage::getStoreConfigFlag(self::CONFIG_GOOGLE_ANALYTICS_IP_ANONYMIZATION)) {
                return $this;
            }

            $matches = array();
            $setAccountExpression = '/_gaq\.push\(\[\'_setAccount\', \'[a-zA-Z0-9-_]+\'\]\);\n/';
            $append = '_gaq.push([\'_gat._anonymizeIp\']);';

            if (preg_match_all($setAccountExpression, $html, $matches) && count($matches) && count($matches[0])) {
                $html = preg_replace($setAccountExpression, $matches[0][0] . $append . "\n", $html);
                $transport->setHtml($html);
            }
        }
        return $this;
    }
}