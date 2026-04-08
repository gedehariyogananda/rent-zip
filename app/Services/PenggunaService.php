<?php

namespace App\Services;

use App\Helpers\FormatJsonPengguna;
use App\Repositories\Interfaces\PenggunaRepositoryInterface;

class PenggunaService
{
    protected $penggunaRepository;

    public function __construct(PenggunaRepositoryInterface $penggunaRepository)
    {
        $this->penggunaRepository = $penggunaRepository;
    }

    public function getPengguna()
    {
        $data = $this->penggunaRepository->getAll();
        $mapData = $data->map(function ($item) {
            return FormatJsonPengguna::formaterBodyJson($item);
        });

        return $mapData;
    }

    public function getSpesificPengguna($id)
    {
        $pengguna = $this->penggunaRepository->find($id);

        return FormatJsonPengguna::formaterBodyJson($pengguna);
    }

    public function createPengguna($data)
    {
        // hashing the request password from data 
        $data['password'] = bcrypt($data['password']);
        $result = $this->penggunaRepository->store($data);

        return FormatJsonPengguna::formaterBodyJson($result);
    }

    public function updatePengguna($data, $id)
    {
        if ($id != auth()->user()->id) {
            return false;
        }

        $dataFound = $this->penggunaRepository->find($id);
        if (!$dataFound) {
            return false;
        }

        // hashing for updating data password
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $forUpdating = $this->penggunaRepository->update($data, $id);
        if (!$forUpdating) {
            return false;
        }

        $dataBaruPengguna = $this->penggunaRepository->find($id);

        return FormatJsonPengguna::formaterBodyJson($dataBaruPengguna);
    }

    public function deletePengguna($id)
    {
        if ($id != auth()->user()->id) {
            return false;
        }

        $dataFound = $this->penggunaRepository->find($id);
        if (!$dataFound) {
            return false;
        }

        $result = $this->penggunaRepository->delete($id);

        return $result;
    }
}
