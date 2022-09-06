<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ConfigsTableSeeder::class);
        $this->command->info('Configs created!');

//        $this->call(PagesTableSeeder::class);
//        $this->command->info('Pages created!');

        $this->call(UsersTableSeeder::class);
        $this->command->info('Users created!');
    }
}
