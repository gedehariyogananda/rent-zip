<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TugasRequest;
use App\Services\TugasService;
use App\Traits\ApiResponse;
use Exception;

class TugasController extends Controller
{
    use ApiResponse;

    protected $tugasService;

    public function __construct(TugasService $tugasService)
    {
        $this->tugasService = $tugasService;
    }

    public function getTugas()
    {
        $data = $this->tugasService->getTugas();
        return $this->apiSuccess($data, 200, 'Data retrieved successfully');
    }

    public function getSpesificTugas($id)
    {
        try {
            $tugas = $this->tugasService->getSpesificTugas($id);
            if (!$tugas) {
                return $this->apiError(404, 'Data not found');
            }

            return $this->apiSuccess($tugas, 200, 'Data retrieved successfully');
        } catch (\Exception $e) {
            return $this->apiError(404, $e->getMessage());
        }
    }

    public function createTugas(TugasRequest $request)
    {
        try {
            $data = $request->validated();
            $result = $this->tugasService->createTugas($data);

            return $this->apiSuccess($result, 201, 'Data created successfully');
        } catch (Exception $e) {
            return $this->apiError(400, $e->getMessage());
        }
    }

    public function updateTugas(TugasRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $result = $this->tugasService->updateTugas($data, $id);

            if (!$result) {
                return $this->apiError(404, 'Data not found');
            }

            return $this->apiSuccess($result, 200, 'Data updated successfully');
        } catch (Exception $e) {
            return $this->apiError(400, $e->getMessage());
        }
    }

    public function deleteTugas($id)
    {
        try {
            $result = $this->tugasService->deleteTugas($id);

            return $this->apiSuccess($result, 200, 'Data deleted successfully');
        } catch (Exception $e) {
            return $this->apiError(400, $e->getMessage());
        }
    }
}
