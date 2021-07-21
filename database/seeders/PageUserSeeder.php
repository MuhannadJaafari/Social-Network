<?php

namespace Database\Seeders;

use App\Models\PageUser;
use Illuminate\Database\Seeder;

class PageUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PageUser::factory()->count(20)->create();
    }
}
