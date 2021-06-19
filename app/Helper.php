<?php


namespace App;

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

}
