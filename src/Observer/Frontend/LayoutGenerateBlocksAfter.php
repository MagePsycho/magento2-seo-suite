<?php

namespace MagePsycho\SeoSuite\Observer\Frontend;

use Magento\Framework\App\Request\Http;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\View\Page\Config as PageConfig;
use MagePsycho\SeoSuite\Helper\Data as SeoSuiteHelper;
use MagePsycho\SeoSuite\Model\RouteResolver;

/**
 * @category   MagePsycho
 * @package    MagePsycho_SeoSuite
 * @author     Raj KB <rajkb@magepsycho.com>
 * @website    https://www.magepsycho.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class LayoutGenerateBlocksAfter implements ObserverInterface
{
    private const META_ROBOTS_VALUE = 'NOINDEX,NOFOLLOW';

    /**
     * @var SeoSuiteHelper
     */
    private $seoSuiteHelper;

    /**
     * @var Http
     */
    private $http;

    /**
     * @var PageConfig
     */
    private $pageConfig;

    /**
     * @var RouteResolver
     */
    private $routeResolver;

    public function __construct(
        SeoSuiteHelper $seoSuiteHelper,
        Http $http,
        PageConfig $pageConfig,
        RouteResolver $routeResolver
    ) {
        $this->seoSuiteHelper = $seoSuiteHelper;
        $this->http = $http;
        $this->pageConfig = $pageConfig;
        $this->routeResolver = $routeResolver;
    }

    public function execute(Observer $observer)
    {
        $currentRoute = $this->http->getFullActionName('/');
        $this->seoSuiteHelper->log(__METHOD__ . '::$currentRoute::' . $currentRoute, true);

        if ($currentRoute == 'contact/index/index') {
            $this->pageConfig->addRemotePageAsset(
                $this->seoSuiteHelper->getBaseUrl() . 'contact',
                'canonical',
                ['attributes' => ['rel' => 'canonical']]
            );
        }

        $allowedRoutes = $this->seoSuiteHelper->getConfig()->getRobotsNoIndexRoutes();
        if (!$this->routeResolver->match($currentRoute, $allowedRoutes)) {
            return;
        }
        $this->pageConfig->setMetadata('robots', self::META_ROBOTS_VALUE);
    }
}
