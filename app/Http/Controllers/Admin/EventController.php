<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::orderByDesc("created_at")->get();
        return view("admin.events.index", compact("events"));
    }

    public function create()
    {
        return view("admin.events.create");
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|string|max:255",
            "date" => "required|date",
            "location" => "required|string|max:255",
            "image" => "nullable|image|mimes:jpeg,png,jpg,webp|max:10240",
        ]);

        $data = $request->only(["name", "date", "location"]);

        if ($request->hasFile("image")) {
            $data["image_url"] = $request
                ->file("image")
                ->store("events", "public");
        }

        $event = Event::create($data);

        $users = \App\Models\User::where("role_id", 2)->get();
        foreach ($users as $user) {
            \App\Models\Notification::create([
                "user_id" => $user->id,
                "title" => "Event Baru: " . $event->name,
                "message" =>
                    "Jangan lewatkan event " .
                    $event->name .
                    " di " .
                    $event->location .
                    " pada tanggal " .
                    \Carbon\Carbon::parse($event->date)->format("d M Y") .
                    "!",
            ]);
        }

        return redirect()
            ->route("admin.events.index")
            ->with("success", "Event berhasil ditambahkan");
    }

    public function edit(Event $event)
    {
        return view("admin.events.edit", compact("event"));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            "name" => "required|string|max:255",
            "date" => "required|date",
            "location" => "required|string|max:255",
            "image" => "nullable|image|mimes:jpeg,png,jpg,webp|max:10240",
        ]);

        $data = $request->only(["name", "date", "location"]);

        if ($request->hasFile("image")) {
            if (
                $event->image_url &&
                Storage::disk("public")->exists($event->image_url)
            ) {
                Storage::disk("public")->delete($event->image_url);
            }
            $data["image_url"] = $request
                ->file("image")
                ->store("events", "public");
        }

        $event->update($data);

        return redirect()
            ->route("admin.events.index")
            ->with("success", "Event berhasil diperbarui");
    }

    public function destroy(Event $event)
    {
        if (
            $event->image_url &&
            Storage::disk("public")->exists($event->image_url)
        ) {
            Storage::disk("public")->delete($event->image_url);
        }

        $event->delete();

        return redirect()
            ->route("admin.events.index")
            ->with("success", "Event berhasil dihapus");
    }
}
