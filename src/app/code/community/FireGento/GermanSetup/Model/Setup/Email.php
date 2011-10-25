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
 * @copyright 2011 FireGento Team (http://www.firegento.de). All rights served.
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License, version 3 (GPLv3)
 * @version   $Id:$
 * @since     0.2.0
 */
/**
 * Setup class
 *
 * @category  FireGento
 * @package   FireGento_GermanSetup
 * @author    FireGento Team <team@firegento.com>
 * @copyright 2011 FireGento Team (http://www.firegento.de). All rights served.
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License, version 3 (GPLv3)
 * @version   $Id:$
 * @since     0.2.0
 */
class FireGento_GermanSetup_Model_Setup_Email extends FireGento_GermanSetup_Model_Setup_Abstract
{

    public function setup()
    {
        // execute emails
        foreach ($this->getConfigEmails() as $data) {
            if ($data['execute'] == 1) {
                $this->createEmail($data, false);
            }
        }
    }

    /**
     * Get emails/default from config file
     *
     * @return array
     */
    public function getConfigEmails()
    {
        return $this->_getConfigNode('emails', 'default');
    }

    /**
     * Create transactional email template
     *
     * @param array $emailData template data
     * @param boolean $override override email template if set
     *
     * @return voids
     */
    public function createEmail($emailData, $override=true)
    {
        $model = Mage::getModel('core/email_template');
        $template = $model->loadByCode($emailData['template_code']);
        if (!$template->getId()) {
            // create
            $template = $model->setTemplateSubject($emailData['template_subject'])
                ->setTemplateCode($emailData['template_code'])
                ->setTemplateText($this->getTemplateContent($emailData['text']))
                ->setTemplateType($emailData['template_type'])
                ->setModifiedAt(Mage::getSingleton('core/date')->gmtDate())
                ->save();
        } else {
            //update
            if ($override) {
                $template->setTemplateSubject($emailData['template_subject'])
                    ->setTemplateCode($emailData['template_code'])
                    ->setTemplateText($this->getTemplateContent($emailData['text']))
                    ->setTemplateType($emailData['template_type'])
                    ->setModifiedAt(Mage::getSingleton('core/date')->gmtDate())
                    ->save();
            }
        }

        $this->setConfigData($emailData['config_data_path'], $template->getId());
    }
}
