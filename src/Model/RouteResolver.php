<?php

namespace MagePsycho\SeoSuite\Model;

/**
 * @category   MagePsycho
 * @package    MagePsycho_SeoSuite
 * @author     Raj KB <rajkb@magepsycho.com>
 * @website    https://www.magepsycho.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class RouteResolver
{
    public function match($route, array $allowedRoutes)
    {
        $routeParts = explode('/', $route);
        $currentRouteFront = $routeParts[0] ?? '';
        $currentRouteController = $routeParts[1] ?? 'index';
        $currentRouteAction = $routeParts[2] ?? 'index';

        foreach ($allowedRoutes as $allowedRoute) {
            if (empty($allowedRoute)) {
                continue;
            }
            $allowedRoute = preg_replace('/\s+/', '', trim($allowedRoute, '/'));
            $allowedRouteParts = explode('/', $allowedRoute);
            $allowedRouteFront = $allowedRouteParts[0] ?? '';
            $allowedRouteController = $allowedRouteParts[1] ?? 'index';
            $allowedRouteAction = $allowedRouteParts[2] ?? 'index';

            if ($currentRouteFront == $allowedRouteFront
                && in_array($allowedRouteController, ['*', $currentRouteController])
                && in_array($allowedRouteAction, ['*', $currentRouteAction])
            ) {
                return true;
            }
        }

        return false;
    }
}
