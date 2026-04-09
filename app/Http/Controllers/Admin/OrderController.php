<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        $orders = $this->orderService->getAll();
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = $this->orderService->find($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        // TODO: implement
        return redirect()->route('admin.orders.index');
    }

    public function destroy($id)
    {
        // TODO: implement
        return redirect()->route('admin.orders.index');
    }
}
