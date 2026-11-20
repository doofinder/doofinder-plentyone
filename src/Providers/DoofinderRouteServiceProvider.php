<?php

namespace Doofinder\Providers;

use Plenty\Plugin\RouteServiceProvider;
use Plenty\Plugin\Routing\ApiRouter;
use Plenty\Plugin\Routing\Router;

class DoofinderRouteServiceProvider extends RouteServiceProvider
{
    public function map(Router $router, ApiRouter $api)
    {
        $api->version(['v1'], ['namespace' => 'Doofinder\Api\Resources'], function (ApiRouter $api) {
            $api->get('doofinder/v1/shop', 'ShopResource@show');
            $api->get('doofinder/v1/feed', 'FeedResource@index');
        });
    }
}
