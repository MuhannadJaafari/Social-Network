<?php

namespace Database\Seeders;

use App\Models\RelationUser;
use Illuminate\Database\Seeder;

class RealtionUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RelationUser::factory()->count(10)->create();
    }
}
