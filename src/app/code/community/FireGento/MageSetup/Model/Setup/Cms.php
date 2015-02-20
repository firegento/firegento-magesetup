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
 * Setup class for CMS pages and blocks
 *
 * @category FireGento
 * @package  FireGento_MageSetup
 * @author   FireGento Team <team@firegento.com>
 */
class FireGento_MageSetup_Model_Setup_Cms extends FireGento_MageSetup_Model_Setup_Abstract
{
    /**
     * @var array
     */
    protected $_footerLinks = array();

    /**
     * Setup Pages, Blocks and especially Footer Block
     *
     * @param array $locale Locale options
     */
    public function setup($locale = array('default' => 'de_DE'))
    {
        foreach ($locale as $storeId => $localeCode) {

            if (!$localeCode) {
                continue;
            }

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
                    if ($name == 'footerlinks') {
                        $this->_updateFooterLinksBlock($data, $storeId);
                    } else {
                        $this->_createCmsBlock($data, $localeCode, true, $storeId);
                    }
                }
            }
        }
    }

    /**
     * Sort Config Nodes based on values of a given tagname, defaults to <position>
     *
     * @param array  $nodes
     * @param string $sortTag
     *
     * @return array Config Nodes
     */
    protected function _sortConfigNodes(array $nodes, $sortTag = 'position')
    {
        $i = 0;
        foreach ($nodes as &$node) {
            if (array_key_exists($sortTag, $node) && !is_null($node[$sortTag]) && $node[$sortTag] > $i) {
                $i = $node[$sortTag];
            }
        }
        foreach ($nodes as &$node) {
            if (!array_key_exists($sortTag, $node) || is_null($node[$sortTag])) {
                $i += 10;
                $node[$sortTag] = (string)$i;
            }
        }

        uasort($nodes, function ($a, $b) {
            if ($a['position'] == $b['position']) {
                return 0;
            }

            return ($a['position'] < $b['position']) ? -1 : 1;
        });

        return $nodes;
    }

    /**
     * Get pages/default from config file
     *
     * @return array Config pages
     */
    protected function _getConfigPages()
    {
        $configPages = $this->_getConfigNode('pages', 'default');
        $configPages = $this->_sortConfigNodes($configPages);

        return $configPages;
    }

    /**
     * Get blocks/default from config file
     *
     * @return array Config blocks
     */
    protected function _getConfigBlocks()
    {
        return $this->_getConfigNode('blocks', 'default');
    }

    /**
     * Get footer_links/default from config file
     *
     * @param  int|null $storeId Store ID
     * @return array Footer Links
     */
    protected function _getFooterLinks($storeId)
    {
        if (!$storeId) {
            $storeId = 'default';
        }
        if (!isset($this->_footerLinks[$storeId])) {
            return array();
        }

        return $this->_footerLinks[$storeId];
    }

    /**
     * Collect data and create CMS page
     *
     * @param  array    $pageData Cms page data
     * @param  string   $locale   Locale
     * @param  boolean  $override Override email template if set
     * @param  int|null $storeId  Store ID
     * @return void
     */
    protected function _createCmsPage($pageData, $locale, $override = true, $storeId = null)
    {
        if (!is_array($pageData)) {
            return;
        }

        $data = array(
            'stores'    => $storeId ? $storeId : 0,
            'is_active' => 1,
        );

        $filename = Mage::getBaseDir('locale') . DS . $locale . DS . 'template' . DS . $pageData['filename'];
        if (!file_exists($filename)) {
            return;
        }

        $templateContent = $this->getTemplateContent($filename);

        if (preg_match('/<!--@title\s*(.*?)\s*@-->/u', $templateContent, $matches)) {
            $data['title'] = $matches[1];
            $data['content_heading'] = $matches[1];
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

        if (is_null($storeId)) {
            $page = $this->_getDefaultPage($data['identifier']);
        } else {
            $page = Mage::getModel('cms/page')->setStoreId($storeId)->load($data['identifier']);
        }

        if (is_array($page->getStoreId()) && !in_array(intval($storeId), $page->getStoreId())) {
            $page = Mage::getModel('cms/page');
        } else {
            $data['page_id'] = $page->getId();
        }

        if (!(int)$page->getId() || $override) {
            $page->addData($data);
            $page->save();
        }

        if (!$storeId) {
            $storeId = 'default';
        }

        if ($pageData['footerlink'] == 1) {
            $this->_footerLinks[$storeId][] = array(
                'title'  => $data['title'],
                'target' => $data['identifier'],
            );
        }

        if (isset($pageData['config_option'])) {
            $this->setConfigData($pageData['config_option'], $data['identifier'], $storeId);
        }
    }

    /**
     * Collect data and create CMS block
     *
     * @param  array    $blockData Cms block data
     * @param  string   $locale    Locale
     * @param  boolean  $override  Override email template if set
     * @param  int|null $storeId   Store ID
     * @return void
     */
    protected function _createCmsBlock($blockData, $locale, $override = true, $storeId = null)
    {
        $block = Mage::getModel('cms/block')->setStoreId($storeId)->load($blockData['identifier']);
        if (is_array($block->getStores()) && !in_array(intval($storeId), $block->getStores())) {
            $block = Mage::getModel('cms/block');
        }

        $filename = Mage::getBaseDir('locale') . DS . $locale . DS . 'template' . DS . $blockData['filename'];
        if (!file_exists($filename)) {
            return;
        }

        $templateContent = $this->getTemplateContent($filename);

        // Find title
        if (preg_match('/<!--@title\s*(.*?)\s*@-->/u', $templateContent, $matches)) {
            $blockData['title'] = $matches[1];
            $templateContent = str_replace($matches[0], '', $templateContent);
        }

        // Remove comment lines
        $templateContent = preg_replace('#\{\*.*\*\}#suU', '', $templateContent);

        if (!$block->getId() || $override) {
            $blockData['content'] = $templateContent;
            $blockData['stores'] = $storeId ? $storeId : 0;
            $blockData['is_active'] = '1';
            $blockData['block_id'] = $block->getId();

            $block->setData($blockData)->save();
        }
    }

    /**
     * Generate footer_links block from config data
     *
     * @param  int|null $storeId Store ID
     * @return string Footer Links Content
     */
    protected function _createFooterLinksContent($storeId)
    {
        $footerLinksHtml = '<ul>';
        $footerLinksCounter = 0;

        foreach ($this->_getFooterLinks($storeId) as $data) {
            $footerLinksCounter++;
            $title = $data['title'];
            $target = $data['target'];
            $class = '';
            if ($footerLinksCounter == count($this->_getFooterLinks($storeId))) {
                $class = 'last';
            }
            $footerLinksHtml .= '<li class="' . $class . '">';
            $footerLinksHtml .= '<a href="{{store url="' . $target . '"}}">' . $title . '</a></li>';
        }

        $footerLinksHtml .= '</ul>';

        return $footerLinksHtml;
    }

    /**
     * Update footer_links cms block
     *
     * @param array    $blockData Cms block data
     * @param int|null $storeId   Store ID
     */
    protected function _updateFooterLinksBlock($blockData, $storeId = null)
    {
        /** @var $block Mage_Cms_Model_Block */
        if (is_null($storeId)) {
            $block = $this->_getDefaultBlock('footer_links');
        } else {
            $block = Mage::getModel('cms/block')->setStoreId($storeId)->load('footer_links');
        }

        if (is_array($block->getStores()) && !in_array(intval($storeId), $block->getStores())) {
            $block = Mage::getModel('cms/block');
        }

        if ($block->getId()) {

            /** @var $backupBlock Mage_Cms_Model_Block */
            $backupBlock = Mage::getModel('cms/block')->load('footer_links_backup');
            if (!$backupBlock->getId()) {

                // create copy of original block
                $data = array();
                $data['block_id'] = $block->getId();
                $data['identifier'] = 'footer_links_backup';

                $block->setData($data)->save();

                /** @var $block Mage_Cms_Model_Block */
                $block = Mage::getModel('cms/block');
            }
        }

        $data = array(
            'title'      => 'Footer Links',
            'identifier' => 'footer_links',
            'content'    => $this->_createFooterLinksContent($storeId),
            'stores'     => $storeId ? $storeId : 0,
            'is_active'  => '1',
        );

        if ($storeId) {
            $data['stores'] = array($storeId);
        }

        $block->addData($data)->save();
    }

    /**
     * Retrieve the default block for the given identifier
     *
     * @param  string $identifier Block Identifier
     * @return Mage_Cms_Model_Block Block Model
     */
    protected function _getDefaultBlock($identifier)
    {
        return Mage::getResourceModel('cms/block_collection')
            ->addFieldToFilter('identifier', $identifier)
            ->addStoreFilter(0)->getFirstItem();
    }

    /**
     * Retrieve the default page for the given identifier
     *
     * @param  string $identifier Page Identifier
     * @return Mage_Cms_Model_Page Page Model
     */
    protected function _getDefaultPage($identifier)
    {
        return Mage::getResourceModel('cms/page_collection')
            ->addFieldToFilter('identifier', $identifier)
            ->addStoreFilter(0)->getFirstItem();
    }
}
