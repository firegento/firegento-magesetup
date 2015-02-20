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
 * @since     0.2.0
 */

/**
 * Setup class for transaction emails
 *
 * @category FireGento
 * @package  FireGento_MageSetup
 * @author   FireGento Team <team@firegento.com>
 */
class FireGento_MageSetup_Model_Setup_Email extends FireGento_MageSetup_Model_Setup_Abstract
{
    /**
     * @var array
     */
    protected $_localeTemplatePath = array();

    /**
     * Setup Transaction Emails
     *
     * @param array $locale    Locale options
     * @param bool  $overwrite Flag if locale options should override existing templates
     */
    public function setup($locale = array('default' => 'de_DE'), $overwrite = false)
    {
        foreach ($locale as $storeId => $localeCode) {

            if (!$localeCode) {
                continue;
            }

            if ($storeId == 'default') {
                $storeId = null;
            }

            // execute emails
            foreach ($this->_getConfigEmails($localeCode) as $data) {

                if ($data['execute'] == 1) {

                    // Change override param from false to true to override existing templates for testing
                    $this->_createEmail($data, $localeCode, $overwrite, $storeId);
                }
            }
        }
    }

    /**
     * Get email_footers/default from config file
     *
     * @return array Config email footers
     */
    protected function _getConfigEmailFooters()
    {
        return $this->_getConfigNode('email_footers', 'default');
    }

    /**
     * Get emails/default from config file
     *
     * @return array Config emails
     */
    protected function _getConfigEmails()
    {
        return $this->_getConfigNode('emails', 'default');
    }

    /**
     * Create transactional email template
     *
     * @param  array    $emailData Template data
     * @param  string   $locale    Locale
     * @param  boolean  $override  Override email template if set
     * @param  int|null $storeId   Store ID
     * @return void
     */
    protected function _createEmail($emailData, $locale, $override = true, $storeId = null)
    {
        $templateCode = $emailData['template_code'] . ' (' . $locale . ')';
        $template = Mage::getModel('core/email_template')
            ->loadByCode($templateCode);

        if (!$template->getId() || $override) {

            $localeEmailPath = $this->_getLocaleEmailPath($locale);

            $template
                ->setTemplateCode($templateCode)
                ->setTemplateType($emailData['template_type'])
                ->setAddedAt(Mage::getSingleton('core/date')->gmtDate())
                ->setModifiedAt(Mage::getSingleton('core/date')->gmtDate());

            // Filter areas from template file
            $templateText = $this->getTemplateContent($localeEmailPath . $emailData['template_file']);

            if (!$templateText) {
                return; // file not found: return silently
            }

            if (preg_match('/<!--@subject\s*(.*?)\s*@-->/u', $templateText, $matches)) {
                $template->setTemplateSubject($matches[1]);
                $templateText = str_replace($matches[0], '', $templateText);
            }

            if (preg_match('/<!--@vars\s*((?:.)*?)\s*@-->/us', $templateText, $matches)) {
                $templateText = str_replace($matches[0], '', $templateText);
            }

            if (preg_match('/<!--@styles\s*(.*?)\s*@-->/s', $templateText, $matches)) {
                $template->setTemplateStyles($matches[1]);
                $templateText = str_replace($matches[0], '', $templateText);
            }

            // Remove comment lines
            $templateText = preg_replace('#\{\*.*\*\}#suU', '', $templateText);

            $footerBlocks = $this->_getFooterBlocks($emailData);
            $templateText = $this->_addFooterBlocks($templateText, $footerBlocks);

            $template
                ->setTemplateText($templateText)
                ->save();
        }

        $this->setConfigData($emailData['config_data_path'], $template->getId(), $storeId);
    }

    /**
     * Retrieve email template path for given locale
     *
     * @param  string $locale Locale
     * @return string Locale Template Path
     */
    protected function _getLocaleEmailPath($locale)
    {
        if (!isset($this->_localeTemplatePath[$locale])) {
            $_localeTemplatePath = 'app' . DS . 'locale' . DS . $locale . DS . 'template' . DS . 'email' . DS;
            $this->_localeTemplatePath[$locale] = Mage::getBaseDir() . DS . $_localeTemplatePath;

            if (!is_dir($this->_localeTemplatePath[$locale])) {
                Mage::throwException(
                    Mage::helper('magesetup')->__(
                        'Directory "%s" not found. Locale not installed?',
                        $this->_localeTemplatePath[$locale]
                    )
                );
            }
        }

        return $this->_localeTemplatePath[$locale];
    }

    /**
     * Add configured blocks before the second last </body> tag
     *
     * @param  string $templateText the content of the template
     * @param  array  $blocks       all blocks that should be inserted before penultimate </table>
     * @return string the content of the template with the block before penultimate </table>
     */
    protected function _addFooterBlocks($templateText, array $blocks = array())
    {
        $origTemplateText = $templateText;
        $lastPos = strripos($templateText, '</table>');
        if ($lastPos === false) {
            return $origTemplateText;
        }
        $part = substr($templateText, 0, $lastPos);
        $penultimatePos = strripos($part, '</table>');
        if ($penultimatePos === false) {
            return $origTemplateText;
        }
        $templateText = substr($templateText, 0, $penultimatePos);
        foreach ($blocks as $block) {
            $templateText .= $block;
        }
        $templateText .= substr($origTemplateText, $penultimatePos);

        return $templateText;
    }

    /**
     * Get HTML blocks which should be appended to the emails
     *
     * @param  array $emailData Email data
     * @return array Footer blocks
     */
    protected function _getFooterBlocks($emailData)
    {
        $configFooters = $this->_getConfigEmailFooters();
        $blocks = array();
        if ($emailData['add_footer'] == 1) {
            $blocks[] = $configFooters['footer'];
        }
        if ($emailData['add_business_terms'] == 1) {
            $blocks[] = $configFooters['business_terms'];
        }
        if ($emailData['add_revocation'] == 1) {
            $blocks[] = $configFooters['revocation'];
        }

        if ($emailData['add_revocation_form'] == 1) {
            $blocks[] = $configFooters['revocation_form'];
        }

        return $blocks;
    }
}
