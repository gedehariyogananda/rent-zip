<?php

namespace App\Http\Controllers\Member;

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
        $orders = $this->orderService->findByUserId(auth()->id());
        return view('member.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = $this->orderService->find($id);
        return view('member.orders.show', compact('order'));
    }

    public function store(Request $request)
    {
        // TODO: implement
        return redirect()->route('member.orders.index');
    }
}
