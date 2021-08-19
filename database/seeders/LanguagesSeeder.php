<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $languages = [
            [
                'name' => 'English',
                'code' => 'en',
                'is_default' => 1
            ]
           ];
        foreach($languages as $language)
        {
            Language::create($language);
        }
    }
}
