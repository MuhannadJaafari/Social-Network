<?php

namespace Database\Seeders;

use App\Models\HashtagsUser;
use Illuminate\Database\Seeder;

class HashtagUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        HashtagsUser::factory()->count(20)->create();
    }
}
