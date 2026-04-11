<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\CostumService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Exception;

class CostumController extends Controller
{
    use ApiResponse;

    protected CostumService $costumService;

    public function __construct(CostumService $costumService)
    {
        $this->costumService = $costumService;
    }

    /**
     * Get all costums with pagination and filtering
     *
     * Endpoint: GET /api/v1/costums
     */
    public function index(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 10);
            $filters = [
                'search' => $request->input('search'),
                'source_anime_category_id' => $request->input('source_anime_category_id'),
                'brand_costum_category_id' => $request->input('brand_costum_category_id'),
                'lokasi' => $request->input('lokasi'),
            ];

            $costums = $this->costumService->paginate($perPage, $filters);

            // Format the response to include full photo URL
            $costums->getCollection()->transform(function ($costum) {
                if ($costum->photo_url) {
                    $costum->photo_url = url('storage/' . $costum->photo_url);
                }
                return $costum;
            });

            return $this->apiSuccess($costums, 200, 'Costums retrieved successfully');
        } catch (Exception $e) {
            return $this->apiError(500, 'Failed to retrieve costums: ' . $e->getMessage());
        }
    }

    /**
     * Get costum detail by ID
     *
     * Endpoint: GET /api/v1/costums/{id}
     */
    public function show($id)
    {
        try {
            $costum = $this->costumService->find($id);

            if (!$costum) {
                return $this->apiError(404, 'Costum not found');
            }

            if ($costum->photo_url) {
                $costum->photo_url = url('storage/' . $costum->photo_url);
            }

            return $this->apiSuccess($costum, 200, 'Costum retrieved successfully');
        } catch (Exception $e) {
            return $this->apiError(500, 'Failed to retrieve costum details: ' . $e->getMessage());
        }
    }
}
