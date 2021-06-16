<?php


namespace App;
use Illuminate\Support\Collection;

class Helper
{
    public function filter(Collection $model,$keys){
        $arr = [];
        foreach($keys as $key){
            $key = strval($key);
            $arr [$key]  = $model[$key];
        }
        return $arr;
    }

}
