<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Costum;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the member dashboard.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // Get 4 latest costumes for featured section
        $featuredCostumes = Costum::latest()->take(4)->get();

        // Get 2 recent rentals for the current user
        $recentRentals = Order::with('items.costum')
            ->where('user_id', auth()->id())
            ->latest()
            ->take(2)
            ->get();

        // Static upcoming events
        $upcomingEvents = [
            [
                'date' => '24 Oct',
                'title' => 'Anime Expo 2024',
                'location' => 'Jakarta International Expo'
            ],
            [
                'date' => '05 Nov',
                'title' => 'Cosplay Cafe Meetup',
                'location' => 'Grand Indonesia Mall'
            ]
        ];

        return view('member.dashboard', compact(
            'featuredCostumes',
            'recentRentals',
            'upcomingEvents'
        ));
    }
}
