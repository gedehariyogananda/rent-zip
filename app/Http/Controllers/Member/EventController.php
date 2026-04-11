<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query("status", "all"); // all or archived

        $query = Event::query();

        if ($status === "archived") {
            $query->whereDate("date", "<", Carbon::today());
        } else {
            $query->whereDate("date", ">=", Carbon::today());
        }

        $events = $query->orderBy("date", "asc")->get();

        return view("member.events.index", compact("events", "status"));
    }
}
