<?php

namespace MagePsycho\SeoSuite\Controller;

use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\RouterInterface;
use Magento\Framework\DataObject;
use Magento\Framework\Event\ManagerInterface;
use MagePsycho\SeoSuite\Helper\Data as SeoSuiteHelper;

/**
 * @category   MagePsycho
 * @package    MagePsycho_SeoSuite
 * @author     Raj KB <info@magepsycho.com>
 * @website    https://www.magepsycho.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Router implements RouterInterface
{
    /**
     * @var ActionFactory
     */
    protected $actionFactory;

    /**
     * Response
     *
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @var ManagerInterface
     */
    protected $eventManager;

    /**
     * @var SeoSuiteHelper
     */
    protected $seoSuiteHelper;

    public function __construct(
        ActionFactory $actionFactory,
        ResponseInterface $response,
        ManagerInterface $eventManager,
        SeoSuiteHelper $seoSuiteHelper
    ) {
        $this->actionFactory = $actionFactory;
        $this->response = $response;
        $this->eventManager = $eventManager;
        $this->seoSuiteHelper = $seoSuiteHelper;
    }

    public function match(RequestInterface $request)
    {
        if (!$this->seoSuiteHelper->getConfig()->isHtmlSitemapEnabled()) {
            return;
        }

        $pathInfo = trim($request->getPathInfo(), '/');
        if (empty($pathInfo)) {
            return;
        }

        $condition = new DataObject(['identifier' => $pathInfo, 'continue' => true]);
        $this->eventManager->dispatch(
            'magepsycho_seosuite_controller_router_match_before',
            ['router' => $this, 'condition' => $condition]
        );

        if ($condition->getRedirectUrl()) {
            $this->response->setRedirect($condition->getRedirectUrl());
            $request->setDispatched(true);
            return $this->actionFactory->create(
                \Magento\Framework\App\Action\Redirect::class,
                ['request' => $request]
            );
        }

        if (!$condition->getContinue()) {
            return null;
        }

        $identifier = $condition->getIdentifier();
        $params = explode('/', $identifier);
        $requestIdentifier = $params[0] ?? '';

        if ($requestIdentifier == 'sitemap') {
            $request->setModuleName('magepsycho_seosuite')
                ->setControllerName('sitemap')
                ->setActionName('index');
            $request->setAlias(\Magento\Framework\Url::REWRITE_REQUEST_PATH_ALIAS, $identifier);

            return $this->actionFactory->create(
                \Magento\Framework\App\Action\Forward::class,
                ['request' => $request]
            );
        }

        return null;
    }
}
