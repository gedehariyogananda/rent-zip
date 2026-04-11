<?php

namespace Database\Seeders;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            [
                "name" => "Anime Expo 2024",
                "date" => Carbon::now()->addDays(20)->format("Y-m-d"), // Available
                "location" => "Los Angeles, CA",
                "image_url" => null,
            ],
            [
                "name" => "San Diego Comic-Con",
                "date" => Carbon::now()->subDays(15)->format("Y-m-d"), // Archived
                "location" => "San Diego, CA",
                "image_url" => null,
            ],
            [
                "name" => "Dragon Con 2024",
                "date" => Carbon::now()->addMonths(1)->format("Y-m-d"), // Available
                "location" => "Atlanta, GA",
                "image_url" => null,
            ],
            [
                "name" => "NYCC Showcase",
                "date" => Carbon::now()->addMonths(3)->format("Y-m-d"), // Available
                "location" => "New York, NY",
                "image_url" => null,
            ],
            [
                "name" => "Neo-Tokyo Summer Festival",
                "date" => Carbon::now()->subMonths(2)->format("Y-m-d"), // Archived
                "location" => "Convention Center, Hall A",
                "image_url" => null,
            ],
            [
                "name" => "Cosplay Matsuri",
                "date" => Carbon::now()->addDays(5)->format("Y-m-d"), // Available
                "location" => "Jakarta Convention Center",
                "image_url" => null,
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}
