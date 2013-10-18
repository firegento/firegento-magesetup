<?php

class FireGento_MageSetup_Model_Ga_Observer
{
    const CONFIG_GOOGLE_ANALYTICS_IP_ANONYMIZATION = 'google/analytics/ip_anonymization';

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