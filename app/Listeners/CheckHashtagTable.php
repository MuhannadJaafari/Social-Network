<?php

namespace App\Listeners;

use App\Models\Hashtag;
use Illuminate\Support\Facades\DB;

class CheckHashtagTable
{

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle()
    {
//          select DISTINCT name  from hashtags
//          left join hashtagables on
//          hashtags.id = hashtagables.hashtag_id
//          where hashtag_id is null;
        $hashtag_id = DB::table('hashtags')
            ->select('id')
            ->leftJoin('hashtagables', 'hashtags.id', '=', 'hashtagables.hashtag_id')
            ->whereNull('hashtag_id')
            ->first();
        if ($hashtag_id) {
            $hashtag = Hashtag::find($hashtag_id->id);
            $hashtag->delete();
        }
    }
}
