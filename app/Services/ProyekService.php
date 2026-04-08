<?php

namespace App\Services;

use App\Helpers\FormatJsonProyek;
use App\Repositories\Interfaces\ProyekRepositoryInterface;

class ProyekService
{
    protected $proyekRepository;

    public function __construct(ProyekRepositoryInterface $proyekRepository)
    {
        $this->proyekRepository = $proyekRepository;
    }

    public function getProyek()
    {
        $data = $this->proyekRepository->getAll();
        $mapData = $data->map(function ($item) {
            return FormatJsonProyek::formaterBodyJson($item);
        });

        return $mapData;
    }

    public function getSpesificProyek($id)
    {
        $proyek = $this->proyekRepository->find($id);

        return FormatJsonProyek::formaterBodyJson($proyek);
    }


    public function createProyek($data)
    {
        $result = $this->proyekRepository->store($data);

        return FormatJsonProyek::formaterBodyJson($result);
    }

    public function updateProyek($data, $id)
    {
        $dataFound = $this->proyekRepository->find($id);
        if (!$dataFound) {
            return false;
        }

        $isUpdated = $this->proyekRepository->update($data, $id);
        if (!$isUpdated) {
            return false;
        }

        $result = $this->proyekRepository->find($id);

        return FormatJsonProyek::formaterBodyJson($result);
    }


    public function deleteProyek($id)
    {
        $dataFound = $this->proyekRepository->find($id);
        if (!$dataFound) {
            return false;
        }

        $result = $this->proyekRepository->delete($id);

        return $result;
    }
}
