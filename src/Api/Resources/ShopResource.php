<?php

namespace Doofinder\Api\Resources;

use Doofinder\Services\TokenGuard;
use Plenty\Modules\Authorization\Services\AuthHelper;
use Plenty\Modules\System\Contracts\WebstoreRepositoryContract;
use Plenty\Plugin\Application;
use Plenty\Plugin\Controller;
use Plenty\Plugin\Http\Request;
use Plenty\Plugin\Http\Response;

class ShopResource extends Controller
{
    private $request;

    private $response;

    private $tokenGuard;

    public function __construct(Request $request, Response $response, TokenGuard $tokenGuard)
    {
        $this->request = $request;
        $this->response = $response;
        $this->tokenGuard = $tokenGuard;
    }

    /**
     * GET /rest/doofinder/v1/shop
     * The web store of the shop as PlentyOne returns it. The token goes in the X-Doofinder-Token header.
     */
    public function show()
    {
        if (!$this->tokenGuard->allows((string) $this->request->header('X-Doofinder-Token', ''))) {
            return $this->response->json(['error' => 'unauthorized'], 401);
        }

        /** @var AuthHelper $authHelper */
        $authHelper = pluginApp(AuthHelper::class);
        $webstore = $authHelper->processUnguarded(function () {
            $plentyId = pluginApp(Application::class)->getPlentyId();

            return pluginApp(WebstoreRepositoryContract::class)->findByPlentyId($plentyId)->toArray();
        });

        return $this->response->json($webstore, 200);
    }
}
