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
 * @since     0.2.0
 */
/**
 * Setup class for CMS pages and blocks
 *
 * @category  FireGento
 * @package   FireGento_MageSetup
 * @author    FireGento Team <team@firegento.com>
 * @copyright 2013 FireGento Team (http://www.firegento.de). All rights served.
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License, version 3 (GPLv3)
 * @version   $Id:$
 * @since     0.5.0
 */
class FireGento_MageSetup_Model_Setup_Cms extends FireGento_MageSetup_Model_Setup_Abstract
{
    /**
     * Setup Pages, Blocks and especially Footer Block
     *
     * @param array $locale
     * @return void
     */
    public function setup($locale = array('default' => 'de_DE'))
    {
        foreach($locale as $storeId => $localeCode) {

            if (!$localeCode) continue;

            if ($storeId == 'default') {
                $storeId = null;
            }

            // execute pages
            foreach ($this->_getConfigPages($locale) as $name => $data) {
                if ($data['execute'] == 1) {
                    $this->_createCmsPage($data, $localeCode, true, $storeId);
                }
            }

            // execute blocks
            foreach ($this->_getConfigBlocks($locale) as $name => $data) {
                if ($data['execute'] == 1) {
                    if ($name == 'gs_footerlinks') {
                        $this->_updateFooterLinksBlock($data, $storeId);
                    } else {
                        $this->_createCmsBlock($data, $localeCode, true, $storeId);
                    }
                }
            }
        }
    }

    /**
     * Get pages/default from config file
     *
     * @return array
     */
    protected function _getConfigPages()
    {
        return $this->_getConfigNode('pages', 'default');
    }

    /**
     * Get blocks/default from config file
     *
     * @return array
     */
    protected function _getConfigBlocks()
    {
        return $this->_getConfigNode('blocks', 'default');
    }

    /**
     * Get footer_links/default from config file
     *
     * @return array
     */
    protected function _getFooterLinks()
    {
        return $this->_getConfigNode('footer_links', 'default');
    }

    /**
     * Collect data and create CMS page
     *
     * @param array   $pageData cms page data
     * @param string  $locale
     * @param boolean $override  override email template if set
     * @param int|null $storeId
     * @return void
     */
    protected function _createCmsPage($pageData, $locale, $override = true, $storeId = null)
    {
        if (!is_array($pageData)) {
            return null;
        }

        $data = array(
            'stores' => $storeId ? $storeId : 0,
            'is_active' => 1,
        );

        $filename = Mage::getBaseDir('locale') . DS . $locale . DS . 'template' . DS . $pageData['filename'];
        $templateContent = $this->getTemplateContent($filename);

        if (preg_match('/<!--@title\s*(.*?)\s*@-->/u', $templateContent, $matches)) {
            $data['title'] = $matches[1];
            $templateContent = str_replace($matches[0], '', $templateContent);
        }

        if (preg_match('/<!--@identifier\s*((?:.)*?)\s*@-->/us', $templateContent, $matches)) {
            $data['identifier'] = $matches[1];
            $templateContent = str_replace($matches[0], '', $templateContent);
        }

        if (preg_match('/<!--@root_template\s*(.*?)\s*@-->/s', $templateContent, $matches)) {
            $data['root_template'] = $matches[1];
            $templateContent = str_replace($matches[0], '', $templateContent);
        }

        /**
         * Remove comment lines
         */
        $templateContent = preg_replace('#\{\*.*\*\}#suU', '', $templateContent);

        $data['content'] = $templateContent;

        Mage::log($data);

        $page = Mage::getModel('cms/page')->setStoreId($storeId)->load($data['identifier']);
        if (is_array($page->getStoreId()) && !in_array(intval($storeId), $page->getStoreId())) {
            $page = Mage::getModel('cms/page');
        } else {
            $data['page_id'] = $page->getId();
        }

        if (!(int) $page->getId() || $override) {
            $page->setData($data)->save();
        }
    }

    /**
     * Collect data and create CMS block
     *
     * @param array   $blockData cms block data
     * @param string  $locale
     * @param boolean $override  override email template if set
     * @param int|null $storeId
     *
     * @return void
     */
    protected function _createCmsBlock($blockData, $locale, $override = true, $storeId = null)
    {
        $block = Mage::getModel('cms/block')->setStoreId($storeId)->load($blockData['identifier']);
        if (is_array($block->getStores()) && !in_array(intval($storeId), $block->getStores())) {
            $block = Mage::getModel('cms/block');
        }

        $filename = Mage::getBaseDir('locale') . DS . $locale . DS . 'template' . DS . $blockData['filename'];
        $blockData['content'] = $this->getTemplateContent($filename);
        if (!$block->getId() || $override) {
            $blockData['stores'] = $storeId ? $storeId : 0;
            $blockData['is_active'] = '1';
            $blockData['block_id'] = $block->getId();

            $block->setData($blockData)->save();
        }
    }

    /**
     * Generate footer_links block from config data
     *
     * @return string
     */
    protected function _createFooterLinksContent()
    {
        $footerLinksHtml = '<ul>';
        $footerLinksCounter = 0;

        foreach ($this->_getFooterLinks() as $data) {
            $footerLinksCounter++;
            $title = $data['title'];
            $target = $data['target'];
            $class = '';
            if ($footerLinksCounter == count($this->_getFooterLinks())) {
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
     * @param  array $blockData cms block data
     * @param  int|null $storeId
     * @return void
     */
    protected function _updateFooterLinksBlock($blockData, $storeId = null)
    {
        /** @var $block Mage_Cms_Model_Block */
        $block = Mage::getModel('cms/block')->setStoreId($storeId)->load($blockData['identifier']);

        if (is_array($block->getStores()) && !in_array(intval($storeId), $block->getStores())) {
            $block = Mage::getModel('cms/block');
        }

        if ($block->getId()) {

            /** @var $backupBlock Mage_Cms_Model_Block */
            $backupBlock = Mage::getModel('cms/block')->load($blockData['identifier'] . '_backup');
            if (!$backupBlock->getId()) {

                // create copy of original block
                $data = array();
                $data['block_id'] = $block->getId();
                $data['identifier'] = $blockData['identifier'] . '_backup';

                $block->setData($data)->save();

                /** @var $block Mage_Cms_Model_Block */
                $block = Mage::getModel('cms/block');
            }
        }

        $data = array(
            'title' => $blockData['title'],
            'identifier' => $blockData['identifier'],
            'content' => $this->_createFooterLinksContent(),
            'stores' => $storeId ? $storeId : 0,
            'is_active' => '1',
        );

        if ($storeId) {
            $data['stores'] = array($storeId);
        }

        //$block->addData($data)->save();
    }
}
