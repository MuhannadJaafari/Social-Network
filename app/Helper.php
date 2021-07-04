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
        $i = 0;
        foreach ($models as $model) {
            foreach ($keys as $key) {
                $key = strval($key);
                $arr [$i][$key] = $model[$key];
            }
            $i++;
        }
        return $arr;
    }
    public function paginate($items, $perPage = 3, $page = null, $options = [])
    {

        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof \Illuminate\Database\Eloquent\Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
