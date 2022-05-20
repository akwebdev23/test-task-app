<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Factories\SaveFactory;

class TicketController extends Controller
{
    public function create(Request $request){
        $data = json_decode($request->getContent());
        $validateData = [
            'name'=>$data->name, 
            'phone'=>$data->phone, 
            'message'=>$data->message
        ];
        $validator = Validator::make($validateData, [
            'name' => 'required',
            'phone' => 'required|regex:/^\+{0,1}\d{10,12}$/',
            'message' => 'required'
        ]);
        if($validator->fails())
            $response = new Response(json_encode($validator->errors()), 422);

        $modelName = $data->model;
        $storageName = $data->storage;
        if(!$validator->fails()) {
            $result = SaveFactory::saveModel($validateData, $modelName, $storageName);
            if($result)
                $response = new Response($result, 200);
            else
                $response = new Response(['message'=>'Create request error'], 500);
        }
        $response->send();
    }
}
