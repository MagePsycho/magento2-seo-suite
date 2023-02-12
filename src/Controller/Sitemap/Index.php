<?php

namespace MagePsycho\SeoSuite\Controller\Sitemap;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use MagePsycho\SeoSuite\Helper\Data as SeoSuiteHelper;

/**
 * @category   MagePsycho
 * @package    MagePsycho_SeoSuite
 * @author     Raj KB <rajkb@magepsycho.com>
 * @website    https://www.magepsycho.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Index extends Action
{
    private $seoSuiteHelper;

    protected $_resultPageFactory;

    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        SeoSuiteHelper $seoSuiteHelper
    ) {
        $this->seoSuiteHelper = $seoSuiteHelper;
        $this->_resultPageFactory = $pageFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set(
            $this->seoSuiteHelper->getConfig()->getHtmlSitemapMetaTitle()
        );
        $resultPage->getConfig()->setDescription(
            $this->seoSuiteHelper->getConfig()->getHtmlSitemapMetaDescription()
        );
        $resultPage->getConfig()->addRemotePageAsset(
            $this->seoSuiteHelper->getBaseUrl() . 'sitemap',
            'canonical',
            ['attributes' => ['rel' => 'canonical']]
        );

        return $resultPage;
    }
}
