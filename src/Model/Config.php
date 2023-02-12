<?php

namespace MagePsycho\SeoSuite\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * @category   MagePsycho
 * @package    MagePsycho_SeoSuite
 * @author     Raj KB <rajkb@magepsycho.com>
 * @website    https://www.magepsycho.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Config implements ConfigInterface
{
    public const XML_PATH_ENABLED = 'magepsycho_seosuite/general/enabled';
    public const XML_PATH_DEBUG = 'magepsycho_seosuite/general/debug';

    private const XML_PATH_ROBOTS_NOINDEX_ROUTES = 'magepsycho_seosuite/robots/noindex_routes';

    private const XML_PATH_HTML_SITEMAP_ENABLED = 'magepsycho_seosuite/html_sitemap/enabled';
    private const XML_PATH_HTML_SITEMAP_META_TITLE = 'magepsycho_seosuite/html_sitemap/meta_title';
    private const XML_PATH_HTML_SITEMAP_META_DESCRIPTION = 'magepsycho_seosuite/html_sitemap/meta_description';
    private const XML_PATH_HTML_SITEMAP_PRODUCT_LABEL = 'magepsycho_seosuite/html_sitemap/product_label';
    private const XML_PATH_HTML_SITEMAP_CATEGORY_LABEL = 'magepsycho_seosuite/html_sitemap/category_label';
    private const XML_PATH_HTML_SITEMAP_CMS_PAGE_LABEL = 'magepsycho_seosuite/html_sitemap/cms_page_label';

    private const XML_PATH_SEO_PAGINATION_ENABLED = 'magepsycho_seosuite/seo_pagination/enabled';

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @inheritDoc
     */
    public function getConfigFlag($xmlPath, $storeId = null)
    {
        return $this->scopeConfig->isSetFlag(
            $xmlPath,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @inheritDoc
     */
    public function getConfigValue($xmlPath, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $xmlPath,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    public function isEnabled($storeId = null)
    {
        return $this->getConfigFlag(self::XML_PATH_ENABLED, $storeId);
    }

    public function isActive($storeId = null)
    {
        return $this->isEnabled($storeId);
    }

    public function isDebugEnabled($storeId = null)
    {
        return $this->getConfigFlag(self::XML_PATH_DEBUG, $storeId);
    }

    public function getRobotsNoIndexRoutes($storeId = null)
    {
        $routes = $this->getConfigValue(self::XML_PATH_ROBOTS_NOINDEX_ROUTES, $storeId);
        if (empty($routes)) {
            return [];
        }

        return explode("\n", $routes);
    }

    public function isHtmlSitemapEnabled($storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_HTML_SITEMAP_ENABLED, $storeId);
    }

    public function getHtmlSitemapMetaTitle($storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_HTML_SITEMAP_META_TITLE, $storeId);
    }

    public function getHtmlSitemapMetaDescription($storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_HTML_SITEMAP_META_DESCRIPTION, $storeId);
    }

    public function getHtmlSitemapProductLabel($storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_HTML_SITEMAP_PRODUCT_LABEL, $storeId);
    }

    public function getHtmlSitemapCategoryLabel($storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_HTML_SITEMAP_CATEGORY_LABEL, $storeId);
    }

    public function getHtmlSitemapCmsPageLabel($storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_HTML_SITEMAP_CMS_PAGE_LABEL, $storeId);
    }

    public function isSeoPaginationEnabled($storeId = null)
    {
        return $this->getConfigFlag(self::XML_PATH_SEO_PAGINATION_ENABLED, $storeId);
    }
}
