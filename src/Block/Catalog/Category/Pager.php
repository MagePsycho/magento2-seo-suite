<?php

namespace MagePsycho\SeoSuite\Block\Catalog\Category;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use MagePsycho\SeoSuite\Helper\Data as SeoSuiteHelper;

/**
 * @category   MagePsycho
 * @package    MagePsycho_SeoSuite
 * @author     Raj KB <rajkb@magepsycho.com>
 * @website    https://www.magepsycho.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Pager extends Template
{
    /**
     * @var SeoSuiteHelper
     */
    private $seoSuiteHelper;

    public function __construct(
        SeoSuiteHelper $seoSuiteHelper,
        Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->seoSuiteHelper = $seoSuiteHelper;
    }

    protected function _prepareLayout()
    {
        if (!$this->seoSuiteHelper->getConfig()->isSeoPaginationEnabled()) {
            return parent::_prepareLayout();
        }

        // remove the existing canonical URL for category page
        foreach ($this->pageConfig->getAssetCollection()->getGroups() as $group) {
            if ($group->getProperty('content_type') == 'canonical') {
                $assetIdentifiers = array_keys($group->getAll());
                foreach ($assetIdentifiers as $identifier) {
                    $group->remove($identifier);
                }
            }
        }
        return parent::_prepareLayout();
    }

    public function getToolbar()
    {
        $listing = $this->getLayout()->getBlock('category.products.list');
        if (!$listing) {
            return null;
        }

        $toolbar = $listing->getToolbarBlock();
        if (!$toolbar) {
            return null;
        }

        if (!$toolbar->getCollection()) {
            $collection = $listing->getLoadedProductCollection();
            $toolbar->setCollection($collection);
        }

        return $toolbar;
    }

    protected function _beforeToHtml()
    {
        if (!$this->seoSuiteHelper->getConfig()->isSeoPaginationEnabled() || !$this->getToolbar()) {
            $this->setTemplate('');
        }

        return parent::_beforeToHtml();
    }

    public function getCurrentPageUrl()
    {
        $pager = $this->getLayout()->getBlock('product_list_toolbar_pager');
        if ($pager) {
            return $pager->getPageUrl($this->getToolbar()->getCurrentPage());
        }

        return '';
    }

    public function getNextPageUrl()
    {
        $pager = $this->getLayout()->getBlock('product_list_toolbar_pager');
        if ($pager) {
            return $pager->getPageUrl($this->getToolbar()->getCurrentPage() + 1);
        }

        return '';
    }

    public function getPreviousPageUrl()
    {
        $pager = $this->getLayout()->getBlock('product_list_toolbar_pager');
        if ($pager) {
            return $this->getToolbar()->getCurrentPage() > 2
                ? $pager->getPageUrl($this->getToolbar()->getCurrentPage() - 1)
                : $pager->getPageUrl(null);
        }

        return '';
    }

    public function isFirstPage()
    {
        return $this->getToolbar()->isFirstPage();
    }

    public function isLastPage()
    {
        return $this->getToolbar()->getCurrentPage() >= $this->getToolbar()->getLastPageNum();
    }
}
