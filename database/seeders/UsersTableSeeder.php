<?php

namespace Database\Seeders;

use App\Enums\UserRoleEnum;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    const PASSWORD = 'password';
    const NUM_ITEMS = 200;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'email' => 'admin@admin',
            'name' => null,
            'role' => UserRoleEnum::ADMIN,
            'password' => self::PASSWORD,
        ]);

//        $faker = Faker::create('ru_RU');
//        $data = [];
//        for ($i = 0; $i < self::NUM_ITEMS; $i++) {
//            $data[] = [
//                'email' => $faker->email(),
//                'name' => $faker->boolean ? $faker->name() : null,
//                'role' => $faker->randomKey(UserRoleEnum::ROLES),
//                'password' => self::PASSWORD,
//                'is_blocked' => false,
//            ];
//        }
//        User::insert($data);
    }
}
