<?php

namespace Database\Seeders;

use App\Models\Character;
use App\Models\Comic;
use App\Models\Post;
use App\Models\Publisher;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'rafaluquetrujillo@gmail.com',
        ]);


        //PUBLISHERS
        $dc = Publisher::factory(1)->create([
            'name' => 'DC',
        ]);
        $marvel = Publisher::factory(1)->create([
            'name' => 'Marvel',
        ]);

        //CHARACTERS
        $dcCharacters = Character::factory(3)->create([
            'publisher_id' => $dc[0]->id,
        ]);
        $marvelCharacters = Character::factory(3)->create([
            'publisher_id' => $marvel[0]->id,
        ]);

        //COMICS
        $marvelComics = Comic::factory(15)->create([
            'publisher_id' => $marvel[0]->id,
        ]);
        $dcComics = Comic::factory(15)->create([
            'publisher_id' => $dc[0]->id,
        ]);


        //COMICS-CHARACTERS
        foreach ($dcComics as $dcComic) {
            $dcComic->characters()->attach(
                $dcCharacters->random(rand(1, 3))->pluck('id')->toArray()
            );
        }
        foreach ($marvelComics as $marvelComic) {
            $marvelComic->characters()->attach(
                $marvelCharacters->random(rand(1, 3))->pluck('id')->toArray()
            );
        }


//        Comic::factory()->count(500)->create([
//            'thumbnail_image' => null,
//        ]);
//        Character::factory(4)->create([]);
//
//        Comic::factory(15)->create([]);
    }
}
