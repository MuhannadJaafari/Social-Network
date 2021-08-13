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

        for ($i = 1; $i <= 5; $i++) {
            for($j = $i+1;$j<=5;$j++){
                RelationUser::create([
                    'user1_id'=>$i,
                    'user2_id'=>$j,
                    'relation'=>'friends'
                ]);
            }
        }
    }
}
