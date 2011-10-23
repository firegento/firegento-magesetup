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
class FireGento_GermanSetup_Model_Setup_Abstract extends Mage_Eav_Model_Entity_Setup
{
    /**
     * Get config.xml data
     *
     * @return array
     */
    public function getConfigData()
    {
        $configData = Mage::getConfig()
            ->getNode('default/germansetup')
            ->asArray();

        return $configData;
    }

    /**
     * Get config.xml data
     *
     * @param string      $node      xml noce
     * @param string|null $childNode if set, child node of the first noce
     *
     * @return array
     */
    protected function _getConfigNode($node, $childNode = null)
    {
        $configData = $this->getConfigData();
        if ($childNode) {
            return $configData[$node][$childNode];
        } else {
            return $configData[$node];
        }
    }

    /**
     * Get pages/default from config file
     *
     * @return array
     */
    public function getConfigPages()
    {
        return $this->_getConfigNode('pages', 'default');
    }

    /**
     * Get blocks/default from config file
     *
     * @return array
     */
    public function getConfigBlocks()
    {
        return $this->_getConfigNode('blocks', 'default');
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
     * Get imprint from config file
     *
     * @return array
     */
    public function getConfigImprint()
    {
        return $this->_getConfigNode('imprint');
    }

    /**
     * Get template content
     *
     * @param string $filename template file name
     *
     * @return string
     */
    public function getTemplateContent($filename)
    {
        return file_get_contents(Mage::getBaseDir() . DS . $filename);
    }

    /**
     * Get footer_links/default from config file
     *
     * @return array
     */
    public function getFooterLinks()
    {
        return $this->_getConfigNode('footer_links', 'default');
    }

    /**
     * Collect data and create CMS page
     *
     * @param array  $pageData cms page data
     * @param boolean $override override cms page if it exists
     *
     * @return void
     */
    public function createCmsPage($pageData, $override=true)
    {
        if (!is_array($pageData)) {
            return null;
        }

        $pageData = array(
            'title' => $pageData['title'],
            'identifier' => $pageData['identifier'],
            'content' => $this->getTemplateContent($pageData['text']),
            'root_template' => $pageData['root_template'],
            'stores' => array('0'),
            'is_active' => 1,
        );

        $model = Mage::getModel('cms/page');
        $page = $model->load($pageData['identifier']);

        if (!(int)$page->getId()) {
            // create
            $model->setData($pageData)->save();
        } else {
            // update
            if ($override) {

                $pageData['page_id'] = $page->getId();
                $pageData['stores'] = $page->getStoreId();
                $model->setData($pageData)->setId($pageData['page_id'])->save();
            }
        }
    }

    /**
     * Collect data and create CMS block
     *
     * @param array   $blockData cms block data
     * @param boolean $override  override cms block if it exists
     *
     * @return void
     */
    public function createCmsBlock($blockData, $override=true)
    {
        $model = Mage::getModel('cms/block');
        $block = $model->load($blockData['identifier']);
        $blockData['content'] = $this->getTemplateContent($blockData['text']);
        if (!$block->getId()) {
            $blockData['stores'] = array('0');
            $blockData['is_active'] = '1';

            $model->setData($blockData)->save();
        } else {
            if ($override) {
                $blockData['stores'] = array('0');
                $blockData['is_active'] = '1';
                $blockData['block_id'] = $block->getId();
                $model->setData($blockData)->save();
            }
        }
    }

    /**
     * Generate footer_links block from config data
     *
     * @return string
     */
    public function createFooterLinksContent()
    {
        $footerLinksHtml = '<ul>';
        $footerLinksCounter = 0;

        foreach ($this->getFooterLinks() as $data) {
            $footerLinksCounter++;
            $title = $data['title'];
            $target = $data['target'];
            $class = '';
            if ($footerLinksCounter == count($this->getFooterLinks())) {
                $class = 'last';
            }
            $footerLinksHtml .= '<li class="'.$class.'">';
            $footerLinksHtml .= '<a href="{{store url="' . $target . '"}}">' . $title . '</a></li>';
        }

        $footerLinksHtml .= '</ul>';

        return $footerLinksHtml;
    }

    /**
     * Update footer_links cms block
     *
     * @param array $blockData cms block data
     *
     * @return void
     */
    public function updateFooterLinksBlock($blockData)
    {
        $model = Mage::getModel('cms/block');
        $block = $model->load($blockData['identifier']);

        if ($block->getId()) {
            $data = array();
            $data['block_id'] = $block->getId();
            $data['identifier'] = $blockData['identifier'] . '_backup';
            $model->setData($data)->save();
        }

        $data = array(
            'title' => $blockData['title'],
            'identifier' => $blockData['identifier'],
            'content' => $this->createFooterLinksContent(),
            'stores' => array('0'),
            'is_active' => '1',
        );

        $model->setData($data)->save();
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
