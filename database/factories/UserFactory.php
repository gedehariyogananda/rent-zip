<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    public function definition(): array
    {
        $animeNames = [
            'saitama', 'mikasa', 'todoroki', 'nezuko', 'tanjiro',
            'killua', 'gon_freecs', 'kurapika', 'hinata_hyuga',
            'erwin_smith', 'rukia_kuchiki', 'ichigo_kurosaki',
            'edward_elric', 'winry_rockbell', 'lelouch_vi',
        ];

        return [
            'username'  => fake()->unique()->randomElement($animeNames) . '_' . fake()->numerify('###'),
            'email'     => fake()->unique()->safeEmail(),
            'password'  => bcrypt('password'),
            'phone'     => '08' . fake()->numerify('#########'),
            'role_id'   => 2,
            'address'   => fake()->address(),
            'is_active' => true,
        ];
    }
}
