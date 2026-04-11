<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Costum;
use App\Traits\ApiResponse;
use Exception;

class CategoryController extends Controller
{
    use ApiResponse;

    /**
     * Get all source anime categories
     *
     * Endpoint: GET /api/v1/categories/source-animes
     */
    public function sourceAnimes()
    {
        try {
            $categories = Category::where('type', 'source_anime')->orderBy('name')->get();
            return $this->apiSuccess($categories, 200, 'Source anime categories retrieved successfully');
        } catch (Exception $e) {
            return $this->apiError(500, 'Failed to retrieve source anime categories: ' . $e->getMessage());
        }
    }

    /**
     * Get all brand costum categories
     *
     * Endpoint: GET /api/v1/categories/brands
     */
    public function brands()
    {
        try {
            $categories = Category::where('type', 'brand')->orderBy('name')->get();
            return $this->apiSuccess($categories, 200, 'Brand categories retrieved successfully');
        } catch (Exception $e) {
            return $this->apiError(500, 'Failed to retrieve brand categories: ' . $e->getMessage());
        }
    }

    /**
     * Get all unique locations from costums
     *
     * Endpoint: GET /api/v1/locations
     */
    public function locations()
    {
        try {
            $locations = Costum::select('lokasi')
                ->whereNotNull('lokasi')
                ->where('lokasi', '!=', '')
                ->distinct()
                ->pluck('lokasi')
                ->map(function ($lokasi) {
                    return trim($lokasi);
                })
                ->unique()
                ->values()
                ->all();

            return $this->apiSuccess($locations, 200, 'Locations retrieved successfully');
        } catch (Exception $e) {
            return $this->apiError(500, 'Failed to retrieve locations: ' . $e->getMessage());
        }
    }
}
