<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $carts = $this->cartService->findByUserId(auth()->id());
        return view('member.cart.index', compact('carts'));
    }

    public function store(Request $request)
    {
        // TODO: implement
        return redirect()->route('member.cart.index');
    }

    public function update(Request $request, $id)
    {
        // TODO: implement
        return redirect()->route('member.cart.index');
    }

    public function destroy($id)
    {
        // TODO: implement
        return redirect()->route('member.cart.index');
    }
}
