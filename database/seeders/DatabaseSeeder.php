<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
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
            'id' => 99,
            'role_id' => 1,
            'username' => $faker->userName,
            'email' => $faker->email,
            'password' => $faker->password,
            'name' => $faker->name,
            'gender_id' => $faker->numberBetween(1, 3),
            'address' => $faker->address,
            'dob' => date("Y-m-d H:i:s")
        ]);

        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'id' => $i,
                'role_id' => $faker->numberBetween(2, 3),
                'username' => $faker->userName,
                'email' => $faker->email,
                'password' => $faker->password,
                'name' => $faker->name,
                'gender_id' => $faker->numberBetween(1, 3),
                'address' => $faker->address,
                'dob' => date("Y-m-d H:i:s")
            ]);
        }

        for ($i = 1; $i <= 5; $i++) {
            Category::create(['id' => $i, 'name' => $faker->name, 'image_id' => $faker->randomNumber()]);
        }

        for ($i = 1; $i <= 15; $i++) {
            Keyboard::create([
                'id' => $i,
                'name' => $faker->name,
                'description' => $faker->text,
                'category_id' => $faker->numberBetween(1, 5),
                'price' => $faker->numberBetween(100000, 1000000),
                'image_id' => $faker->randomNumber(),
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

        for ($i = 1; $i <= 15; $i++) {
            Transaction::find($i)->keyboards()->attach(Keyboard::all()->random($faker->numberBetween(1, 15)), ['quantity' => $faker->numberBetween(1, 5)]);
        }

        for ($i = 1; $i <= 5; $i++) {
            Cart::find($i)->keyboards()->attach(Keyboard::all()->random($faker->numberBetween(1, 15)), ['quantity' => $faker->numberBetween(1, 5)]);
        }
    }
}
