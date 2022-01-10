<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Gender;
use App\Models\Role;
use App\Models\Category;
use App\Models\Keyboard;
use App\Models\Transaction;
use App\Models\Cart;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $data = [['id' => 1, 'name' => 'male'], ['id' => 2, 'name' => 'female'], ['id' => 3, 'name' => 'other']];

        foreach ($data as $key => $value) {
            Gender::create($value);
        }


        $data = [['id' => 1, 'name' => 'manager'], ['id' => 2, 'name' => 'customer'], ['id' => 3, 'name' => 'guest']];
        foreach ($data as $key => $value) {
            Role::create($value);
        }

        User::create([
            'id' => 101,
            'role_id' => 1,
            'username' => 'manager',
            'email' => 'manager@mail.com',
            'password' =>  '12345678',
            'name' => 'manager',
            'gender_id' => $faker->numberBetween(1, 3),
            'address' =>  Str::random(10),
            'dob' => date("Y-m-d H:i:s")
        ]);

        User::create([
            'id' => 102,
            'role_id' => 2,
            'username' => 'customer',
            'email' => 'customer@mail.com',
            'password' =>  '12345678',
            'name' => 'customer',
            'gender_id' => $faker->numberBetween(1, 3),
            'address' =>  Str::random(10),
            'dob' => date("Y-m-d H:i:s")
        ]);


        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'id' => $i,
                'role_id' => $faker->numberBetween(2, 3),
                'username' => Str::random(5),
                'email' => $faker->email,
                'password' =>  Str::random(8),
                'name' => $faker->name,
                'gender_id' => $faker->numberBetween(1, 3),
                'address' =>  Str::random(10),
                'dob' => date("Y-m-d H:i:s")
            ]);
        }

        for ($i = 1; $i <= 5; $i++) {
            Category::create(['id' => $i, 'name' => $faker->name, 'image_id' => 1]);
        }

        for ($i = 1; $i <= 15; $i++) {
            Keyboard::create([
                'id' => $i,
                'name' => Str::random(5),
                'description' => Str::random(20),
                'category_id' => $faker->numberBetween(1, 5),
                'price' => $faker->numberBetween(100000, 1000000),
                'image_id' => 1,
            ]);
        }

        for ($i = 1; $i <= 15; $i++) {
            Transaction::create([
                'id' => $i,
                'user_id' => $faker->numberBetween(1, 5),
                'timestamp' => date("Y-m-d H:i:s")
            ]);
        }

        for ($i = 1; $i <= 5; $i++) {
            Cart::create([
                'id' => $i,
                'user_id' => $i,
            ]);
        }

        for ($i = 0; $i < 15 * 15; $i++) {
            $x = ($i % 15) + 1;
            Transaction::find($x)->keyboards()->attach(Keyboard::all()->random($faker->numberBetween(1, 15)), ['quantity' => $faker->numberBetween(1, 5)]);
        }

        for ($i = 0; $i < 5 * 5; $i++) {
            $x = ($i % 5) + 1;
            Cart::find($x)->keyboards()->attach(Keyboard::all()->random($faker->numberBetween(1, 15)), ['quantity' => $faker->numberBetween(1, 5)]);
        }
    }
}
