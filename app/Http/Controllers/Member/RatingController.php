<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Services\RatingService;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    protected RatingService $ratingService;

    public function __construct(RatingService $ratingService)
    {
        $this->ratingService = $ratingService;
    }

    // Muncul setelah transaksi pertama selesai jika belum submit rating
    public function prompt()
    {
        $alreadyRated = $this->ratingService->hasRated(auth()->id());
        if ($alreadyRated) {
            return redirect()->route('member.orders.index');
        }
        return view('member.rating.prompt');
    }

    public function store(Request $request)
    {
        // TODO: implement
        return redirect()->route('member.orders.index');
    }

    public function update(Request $request, $id)
    {
        // TODO: implement
        return redirect()->back();
    }
}
