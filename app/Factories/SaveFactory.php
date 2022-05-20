<?php

namespace App\Factories;
use Illuminate\Support\Facades\Storage;


class SaveFactory{
    public static function saveModel($data, $modelName, $storage){
        $className = 'App\\Models\\'.$modelName;
        $instance = new $className($data);
        $modelResult = $instance->save();
        $storage ? $result = self::$storage($data, $instance->id, $modelName) : $result = true;
        return $modelResult && $result ? $instance : false;
    }
    // здесь можно добавлять методы для сохранения данных
    public static function file($data, $id, $modelName){
        $str = '';
        foreach ($data as $key => $value) {
            $str.=$key.':'.$value.";\n";
        }
        $result = Storage::disk('local')->put('/'.strtolower($modelName).'s/ticket_'.$id.'.txt', $str);
        return $result;
    }
}