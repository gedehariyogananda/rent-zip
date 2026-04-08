<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PenggunaRequest;
use App\Services\PenggunaService;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    use ApiResponse;

    protected $penggunaService;

    public function __construct(PenggunaService $penggunaService)
    {
        $this->penggunaService = $penggunaService;
    }

    public function getPengguna()
    {
        try {
            $pengguna = $this->penggunaService->getPengguna();
            return $this->apiSuccess($pengguna, 200, 'successfully returned');
        } catch (Exception $e) {
            return $this->apiError($e->getMessage(), 400);
        }
    }

    public function getSpesificPengguna($id)
    {
        try {
            $pengguna = $this->penggunaService->getSpesificPengguna($id);
            return $this->apiSuccess($pengguna, 200, 'successfully returned');
        } catch (Exception $e) {
            return $this->apiError($e->getMessage(), 400);
        }
    }

    public function createPengguna(PenggunaRequest $request)
    {
        try {
            $data = $request->validated();
            $pengguna = $this->penggunaService->createPengguna($data);
            return $this->apiSuccess($pengguna, 200, 'successfully created');
        } catch (Exception $e) {
            return $this->apiError($e->getMessage(), 400);
        }
    }

    public function updatePengguna(PenggunaRequest $request)
    {
        try {
            $data = $request->validated();
            $pengguna = $this->penggunaService->updatePengguna($data, $request->id);
            if (!$pengguna) {
                return $this->apiError(404, 'NOT UR DATAS');
            }

            return $this->apiSuccess($pengguna, 200, 'successfully updated');
        } catch (Exception $e) {
            return $this->apiError(400, $e->getMessage());
        }
    }

    public function deletePengguna($id)
    {
        try {
            $pengguna = $this->penggunaService->deletePengguna($id);
            if (!$pengguna) {
                return $this->apiError(404, 'NOT UR DATAS');
            }

            return $this->apiSuccess($pengguna, 200, 'successfully deleted');
        } catch (Exception $e) {
            return $this->apiError(400, $e->getMessage());
        }
    }
}
