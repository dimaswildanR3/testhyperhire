<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Person;
use App\Models\Picture;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        Person::factory()->count(30)->create()->each(function ($person) {
           
            $count = rand(1, 5);
            for ($i = 0; $i < $count; $i++) {
                $person->pictures()->create([
                    'url' => "https://picsum.photos/seed/{$person->id}-{$i}/600/600",
                    'position' => $i,
                ]);
            }
        });
    }
}
