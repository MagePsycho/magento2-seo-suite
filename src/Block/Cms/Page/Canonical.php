<?php

namespace MagePsycho\SeoSuite\Block\Cms\Page;

use MagePsycho\SeoSuite\Helper\Data as SeoSuiteHelper;
use Magento\Cms\Model\Page;
use Magento\Framework\View\Element\AbstractBlock;
use Magento\Framework\View\Element\Context;

/**
 * @category   MagePsycho
 * @package    MagePsycho_SeoSuite
 * @author     Raj KB <rajkb@magepsycho.com>
 * @website    https://www.magepsycho.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Canonical extends AbstractBlock
{
    /** @var Page|null */
    protected $page;

    /** @var SeoSuiteHelper */
    protected $seoSuiteHelper;

    public function __construct(
        Context $context,
        Page $page,
        SeoSuiteHelper $seoSuiteHelper,
        array $data = []
    ) {
        $this->page = $page;
        $this->seoSuiteHelper = $seoSuiteHelper;
        parent::__construct($context, $data);
    }

    public function getCanonicalPageUrl()
    {
        if (!$this->page) {
            return false;
        }

        if ($this->isHomePage()) {
            $url = trim($this->getUrl(''), '/');
        } else {
            $url = $this->getUrl() . $this->page->getIdentifier();
        }
        return $url;
    }

    public function _toHtml()
    {
        if ($this->getCanonicalPageUrl()) {
            return PHP_EOL . '<link rel="canonical" href="' . $this->getCanonicalPageUrl() . '"/>' . PHP_EOL;
        }

        return '';
    }

    /**
     * Check if current url is url for home page
     *
     * @return bool
     */
    protected function isHomePage()
    {
        //$currentUrl = $this->getUrl('', ['_current' => true]);
        //$urlRewrite = $this->getUrl('*/*/*', ['_current' => true, '_use_rewrite' => true]);
        return $this->getRequest()->getFullActionName() == 'cms_index_index';
    }
}
