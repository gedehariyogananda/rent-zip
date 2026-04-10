<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Costum;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Omzet (total for paid and done orders)
        $omzet = Order::whereIn("status", ["paid", "done"])->sum("total");

        // 2. Members (users with role_id 2)
        $members = User::where("role_id", 2)->count();

        // 3. Rental Valid (count of paid and done orders)
        $rentalValid = Order::whereIn("status", ["paid", "done"])->count();

        // 4. Kostum Tersedia (sum of available_stock of all costums)
        $kostums = Costum::all();
        $kostumTersedia = $kostums->sum("available_stock");

        // 5. Chart Data (Monthly revenue for current year)
        $chartData = [];
        $currentYear = date("Y");
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = Order::whereIn("status", ["paid", "done"])
                ->whereYear("created_at", $currentYear)
                ->whereMonth("created_at", $i)
                ->sum("total");
        }

        // 6. Popular Sources (Top 4 source_anime categories by rental count)
        $popularSources = Category::where("type", "source_anime")
            ->get()
            ->map(function ($category) {
                $rentals = DB::table("order_items")
                    ->join("orders", "orders.id", "=", "order_items.order_id")
                    ->join(
                        "costums",
                        "costums.id",
                        "=",
                        "order_items.costum_id",
                    )
                    ->where("costums.source_anime_category_id", $category->id)
                    ->whereIn("orders.status", ["paid", "done"])
                    ->sum("order_items.pcs");
                $category->rentals_count = $rentals;
                return $category;
            })
            ->sortByDesc("rentals_count")
            ->take(4)
            ->values();

        return view(
            "admin.dashboard",
            compact(
                "omzet",
                "members",
                "rentalValid",
                "kostumTersedia",
                "chartData",
                "popularSources",
            ),
        );
    }
}
