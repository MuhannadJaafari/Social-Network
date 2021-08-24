<?php


namespace App;

use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class Helper
{
    public function filter(Collection $models, $keys)
    {

        $arr = [];
        foreach ($keys as $key) {
            $key = strval($key);
            $arr [$key] = $models[$key];
        }
        return $arr;
    }

    public function paginate($items, $perPage = 3, $page = null, $options = [])
    {

        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof \Illuminate\Database\Eloquent\Collection ? $items : Collection::make($items);
        return (new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options));
    }

    public function mergeObjects($obj1,$obj2){
        $collection = new Collection();
        foreach($obj1->get() as $item){
            $collection->push($item->makeHidden(['pivot','birth_date']));
        }

        foreach($obj2->get() as $item){
            $collection->push($item->makeHidden(['pivot','birth_date']));
        }

        return $collection;
    }
}
