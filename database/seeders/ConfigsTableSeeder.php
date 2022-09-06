<?php

namespace Database\Seeders;

use App\Models\Config;
use Illuminate\Database\Seeder;

class ConfigsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Config::create([
            'emails' => [
//                'aleksandr.voicehovskiy@cyberia.studio',
                'uzuir_gpn-s@gazprom-neft.ru',
            ],
            'sections' => [
                'Планирование', 'Создание корректировок', 'Отчетность', 'Вопросы по отбору', 'Вопросы по семинарам',
            ],
            'purchasing_categories' => [
                'ИТ/Лицензии', 'Услуги и работы общего профиля', 'Производственные работы/услуги',
            ],
        ]);
    }
}
