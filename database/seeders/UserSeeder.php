<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        $admin = User::create([
            'username'   => 'akatsuki_admin',
            'email'      => 'admin@jcosrent.com',
            'password'   => bcrypt('password'),
            'avatar_url' => 'https://ui-avatars.com/api/?name=Admin',
            'phone'      => '081234567890',
            'role_id'    => 1,
            'address'    => 'Jl. Akihabara No. 1, Denpasar, Bali',
            'is_active'  => true,
        ]);

        Profile::create([
            'user_id'        => $admin->id,
            'photo_with_nik' => null,
            'nik'            => '1234567890123456',
            'no_darurat'     => '081234567891',
            'ktp_url'        => null,
        ]);

        // Member dummy — cosplay enthusiast usernames
        $members = [
            ['username' => 'naruto_uzumaki',   'email' => 'naruto@mail.com'],
            ['username' => 'sakura_haruno',     'email' => 'sakura@mail.com'],
            ['username' => 'levi_ackerman',     'email' => 'levi@mail.com'],
            ['username' => 'rem_rezero',        'email' => 'rem@mail.com'],
            ['username' => 'gojo_satoru',       'email' => 'gojo@mail.com'],
            ['username' => 'zero_two_darling',  'email' => 'zerotwo@mail.com'],
            ['username' => 'itachi_uchiha',     'email' => 'itachi@mail.com'],
            ['username' => 'asuka_langley',     'email' => 'asuka@mail.com'],
            ['username' => 'cloud_strife',      'email' => 'cloud@mail.com'],
            ['username' => 'miku_hatsune',      'email' => 'miku@mail.com'],
        ];

        foreach ($members as $member) {
            $user = User::create([
                'username'   => $member['username'],
                'email'      => $member['email'],
                'password'   => bcrypt('password'),
                'avatar_url' => 'https://ui-avatars.com/api/?name=' . urlencode($member['username']),
                'phone'      => '08' . rand(100000000, 999999999),
                'role_id'    => 2,
                'address'    => 'Jl. Cosplay No. ' . rand(1, 99) . ', Denpasar, Bali',
                'is_active'  => true,
            ]);

            Profile::create([
                'user_id'        => $user->id,
                'photo_with_nik' => null,
                'nik'            => (string) rand(1000000000000000, 9999999999999999),
                'no_darurat'     => null,
                'ktp_url'        => null,
            ]);
        }
    }
}
