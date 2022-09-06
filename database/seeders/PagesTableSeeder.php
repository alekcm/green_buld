<?php

namespace Database\Seeders;

use App\Entities\DataTransferObjects\Pages\ContentTableDTO;
use App\Enums\UserRoleEnum;
use App\Models\Page;
use App\Services\Pages\PageService;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
{
    public function getContentH2(string $text): string
    {
        return '<h2>' . $text . '</h2>';
    }

    public function getContentP(string $text): string
    {
        return '<p>' . $text . '</p>';
    }

    public function getContentH3(string $text): string
    {
        return '<h3>' . $text . '</h3>';
    }

    public function run()
    {
        $faker = Faker::create('ru_RU');

        $names = [
            'Управление доступами к АС и ресурсам',
            'Словарь терминов',
            'Обучение',
            'Ведение отчетности в журнале заявок',
            'Структура ЦЗУиР',
        ];

        $parent = null;
        $i = 1;
        foreach ($names as $name) {
            $content = '';

            for ($g = 0; $g < 5; $g++) {
                $content = $content . $this->getContentH2($faker->realText(20));

                $numParagraphs = $faker->randomDigit();
                for ($j = 0; $j < $numParagraphs; $j++) {
                    $content = $content . $this->getContentP($faker->realText());
                }

                $numH3 = $faker->randomDigit();
                for ($k = 0; $k < $numH3; $k++) {
                    $content = $content . $this->getContentH3($faker->realText(20));

                    $numParagraphs2 = $faker->randomDigit();
                    for ($p = 0; $p < $numParagraphs2; $p++) {
                        $content = $content . $this->getContentP($faker->realText());
                    }
                }
            }

            $data = (new PageService())->createContentTable($content);
            $content = $data->getContent();
            $contentTable = array_map(function (ContentTableDTO $table) {
                return $table->toArray();
            }, $data->getContentTable());

            $parent = Page::create([
                'title' => $name,
                'content' => $content,
                'content_table' => $contentTable,
                'show_main' => $parent === null,
                'is_published' => true,
                'order' => $i++,
                'icon' => null,
                'parent_id' => $parent?->id,
                'available' => [$faker->randomKey(UserRoleEnum::AVAILABLE_ROLES)],
            ]);
        }
    }
}
