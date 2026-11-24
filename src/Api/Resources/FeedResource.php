<?php

namespace Doofinder\Api\Resources;

use Doofinder\Services\TokenGuard;
use Plenty\Modules\Authorization\Services\AuthHelper;
use Plenty\Modules\Item\Item\Contracts\ItemRepositoryContract;
use Plenty\Plugin\Controller;
use Plenty\Plugin\Http\Request;
use Plenty\Plugin\Http\Response;

/**
 * The catalog of the shop as JSON: the items with their variations, as PlentyOne returns them.
 * Picking the fields is up to whoever reads the feed.
 */
class FeedResource extends Controller
{
    const RELATIONS = [
        'variations',
        'variations.variationSalesPrices',
        'variations.variationSalesPrices.salesPrice',
        'variations.stock',
        'variations.images',
        'variations.variationCategories',
        'variations.variationCategories.category',
        'variations.variationCategories.category.details',
        'variations.variationDefaultCategory',
        'variations.variationClients',
        'variations.variationBarcodes',
        'variations.variationBarcodes.barcode',
        'variations.variationAttributeValues',
        'variations.variationAttributeValues.attribute',
        'variations.variationAttributeValues.attributeValue',
        'variations.variationProperties',
        'variations.variationProperties.property',
        'variations.variationProperties.property.names',
        'variations.unit',
        'variations.tags',
        'itemImages',
        'itemProperties',
        'manufacturer',
    ];

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
     * GET /rest/doofinder/v1/feed?lang=de&page=1&per_page=50
     * The token is the one that the plugin generates in its configuration, in the X-Doofinder-Token header.
     *
     * Answers one page of items, and whether it is the last one.
     */
    public function index()
    {
        if (!$this->tokenGuard->allows((string) $this->request->header('X-Doofinder-Token', ''))) {
            return $this->response->json(['error' => 'unauthorized'], 401);
        }

        foreach (['lang', 'page', 'per_page'] as $parameter) {
            if ($this->request->get($parameter) === null) {
                return $this->response->json(['error' => $parameter . ' is required'], 400);
            }
        }

        $language = (string) $this->request->get('lang');
        $page = (int) $this->request->get('page');
        $itemsPerPage = (int) $this->request->get('per_page');

        /** @var AuthHelper $authHelper */
        $authHelper = pluginApp(AuthHelper::class);
        $result = $authHelper->processUnguarded(function () use ($language, $page, $itemsPerPage) {
            /** @var ItemRepositoryContract $itemRepository */
            $itemRepository = pluginApp(ItemRepositoryContract::class);

            return $itemRepository->search([], $language, $page, $itemsPerPage, self::RELATIONS);
        });

        return $this->response->json([
            'page' => $page,
            'last_page' => $result->isLastPage(),
            'items' => $result->getResult()->toArray(),
        ], 200);
    }
}
