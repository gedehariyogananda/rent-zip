<?php

namespace App\Services;

use App\Repositories\Interfaces\RatingRepositoryInterface;

class RatingService
{
    protected RatingRepositoryInterface $ratingRepository;

    public function __construct(RatingRepositoryInterface $ratingRepository)
    {
        $this->ratingRepository = $ratingRepository;
    }

    public function getAll()
    {
        return $this->ratingRepository->getAll();
    }

    public function find($id)
    {
        return $this->ratingRepository->find($id);
    }

    public function findByUserId($userId)
    {
        return $this->ratingRepository->findByUserId($userId);
    }

    public function hasRated($userId): bool
    {
        $rating = $this->ratingRepository->findByUserId($userId);
        return $rating !== null && $rating->is_submitted;
    }

    public function create(array $data)
    {
        return $this->ratingRepository->store($data);
    }

    public function update(array $data, $id)
    {
        return $this->ratingRepository->update($data, $id);
    }

    public function delete($id)
    {
        return $this->ratingRepository->delete($id);
    }
}
