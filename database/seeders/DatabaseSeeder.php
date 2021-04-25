<?php

namespace Database\Seeders;

use App\Models\BookItem;
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
        $this->call([
            GenderSeeder::class,
            AuthorSeeder::class,
            CategorySeeder::class,
            BookSeeder::class,
            ConfigSeeder::class,
            BookItemSeeder::class,
            BookCategorySeeder::class,
            UserSeeder::class,
            RelationTypeSeeder::class,
            MemberSeeder::class
        ]);
    }
}
