<?php

namespace App\Services;

use App\Helpers\FormatJsonTugas;
use App\Repositories\Interfaces\TugasRepositoryInterface;

class TugasService
{
    protected $tugasRepository;

    public function __construct(TugasRepositoryInterface $tugasRepository)
    {
        $this->tugasRepository = $tugasRepository;
    }

    public function getTugas()
    {
        $data = $this->tugasRepository->getAll();
        $mapData = $data->map(function ($item) {
            return FormatJsonTugas::formaterBodyJson($item);
        });

        return $mapData;
    }

    public function getSpesificTugas($id)
    {
        $tugas = $this->tugasRepository->find($id);

        return FormatJsonTugas::formaterBodyJson($tugas);
    }

    public function createTugas($data)
    {
        $result = $this->tugasRepository->store($data);

        return FormatJsonTugas::formaterBodyJson($result);
    }

    public function updateTugas($data, $id)
    {
        $dataFound = $this->tugasRepository->find($id);
        if (!$dataFound) {
            return false;
        }


        $isUpdated = $this->tugasRepository->update($data, $id);
        if (!$isUpdated) {
            return false;
        }

        $result = $this->tugasRepository->find($id);

        return FormatJsonTugas::formaterBodyJson($result);
    }


    public function deleteTugas($id)
    {
        $dataFound = $this->tugasRepository->find($id);
        if (!$dataFound) {
            return false;
        }

        $result = $this->tugasRepository->delete($id);

        return $result;
    }
}
