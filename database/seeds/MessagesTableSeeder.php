<?php

use App\Admin\Message as AdminMessage;
use Illuminate\Database\Seeder;

use App\Message;
use Faker\Generator as Faker;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {   
        for ($i=0; $i <20 ; $i++) { 
            Message::create([
                'text' => $faker->text,
                'tipes' => $faker->randomElement(['A', 'B']),
                'url' => $faker->url,
                'start_time' => $faker->dateTime,
                'end_time' => $faker->dateTime,
                'note' => $faker->text,
                'active' => $faker->boolean,
                'user_id' => 1
            ]);
        }
        /* for ($i = 0; $i < 20; $i++) { 
            Message::create([
                'text' => $faker->text,
                'tipes' => $faker->randomElement(['A', 'B']),
                'url' => $faker->url,
                'start_time' => $faker->dateTime,
                'end_time' => $faker->dateTime,
                'note' => $faker->text,
                'active' => $faker->boolean,
                'user_id' => 1
            ]);
        } */
    }
}