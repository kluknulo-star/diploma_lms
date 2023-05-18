<?php

namespace Database\Seeders;

use App\Courses\Models\TypeOfItems;
use Illuminate\Database\Seeder;

class TypeOfItemsSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TypeOfItems::insert(['type' => 'Текст', 'created_at' => NOW(), 'updated_at' => NOW()]);
        TypeOfItems::insert(['type' => 'Изображение', 'created_at' => NOW(), 'updated_at' => NOW()]);
        TypeOfItems::insert(['type' => 'Видео', 'created_at' => NOW(), 'updated_at' => NOW()]);
        TypeOfItems::insert(['type' => 'Тест', 'created_at' => NOW(), 'updated_at' => NOW()]);
    }
}
