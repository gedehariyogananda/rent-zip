<?php

namespace App\Services;

use App\Models\Costum;
use App\Models\Order;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrderService
{
    protected OrderRepositoryInterface $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function getAll()
    {
        return $this->orderRepository->getAll();
    }

    public function find($id)
    {
        return $this->orderRepository->find($id);
    }

    public function findByUserId($userId, array $filters = [])
    {
        return $this->orderRepository->findByUserId($userId, $filters);
    }

    public function createOrder($user, array $data)
    {
        DB::beginTransaction();
        try {
            $costum = Costum::findOrFail($data["costum_id"]);

            if ($costum->available_stock < $data["pcs"]) {
                throw new \Exception(
                    "Stok tidak mencukupi. Sisa stok: " .
                        $costum->available_stock,
                    400,
                );
            }

            $startDate = Carbon::parse($data["start_date"]);
            $endDate = Carbon::parse($data["end_date"]);
            $rentDays = $startDate->diffInDays($endDate) + 1;

            $totalPayment = $costum->calculatePrice($rentDays) * $data["pcs"];

            $profile = $user->profile;
            $isVerified =
                !empty($user->address) &&
                $profile &&
                !empty($profile->nik) &&
                !empty($profile->ktp_url);

            $order = $this->orderRepository->store([
                "user_id" => $user->id,
                "code_booking" => "ORD-" . strtoupper(uniqid()),
                "status" => "pending",
                "total" => $totalPayment,
                "tgl_sewa" => $data["start_date"],
                "tgl_pengembalian" => $data["end_date"],
            ]);

            $order->items()->create([
                "costum_id" => $costum->id,
                "pcs" => $data["pcs"],
            ]);

            DB::commit();

            return [
                "order" => $order->load("items"),
                "verified" => $isVerified,
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function create(array $data)
    {
        return $this->orderRepository->store($data);
    }

    public function update(array $data, $id)
    {
        return $this->orderRepository->update($data, $id);
    }

    public function delete($id)
    {
        return $this->orderRepository->delete($id);
    }

    public function confirmPayment($id, $userId)
    {
        $order = $this->find($id);

        if (!$order || $order->user_id !== $userId) {
            throw new \Exception("Order not found or unauthorized", 404);
        }

        if ($order->status !== "pending") {
            throw new \Exception("Only pending orders can be confirmed", 400);
        }

        $this->update(
            [
                "status" => "paid",
                "qris" => null,
            ],
            $id,
        );

        $order->status = "paid";
        $order->qris = null;

        return $order;
    }
}
