<?php

namespace App\Factories;
use Illuminate\Support\Facades\Storage;


class SaveFactory{
    public static function saveModel($data, $model, $storage){
        $className = 'App\\Models\\'.$model;
        $instance = new $className($data);
        $modelResult = $instance->save();
        $storage ? $result = self::$storage($data, $instance->id, $model) : $result = true;
        return $modelResult && $result ? $instance : false;
    }
    // здесь можно добавлять методы для сохранения данных
    public static function file($data, $id, $model){
        $str = '';
        foreach ($data as $key => $value) {
            $str.=$key.':'.$value.";\n";
        }
        $result = Storage::disk('local')->put('/'.strtolower($model).'s/ticket_'.$id.'.txt', $str);
        return $result;
    }
}