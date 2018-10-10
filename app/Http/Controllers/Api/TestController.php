<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ResponseResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\Routing\Exception\InvalidParameterException;

class TestController extends Controller
{

    //Simplest form but its not have all response information
    /**
    public function index(){
        $test['name'] = 'Its Me Amir';
        return \Response::json($test);
    }

    public function update(Request $request){

        $valid = validator($request->only('name'), [
            'name' => 'required|string',
        ]);

        if ($valid->fails()) {
            return response()->json(["error" => $valid->errors()->first()], 400);
        }

        return response()->json(['success' => 1]);
    }
     */


    public function index(Request $request){

        try {

            $test['id'] = 1;
            $test['name'] = 'Its Me Amir';

            $response = new ResponseResource($test);
            $response->setHttpCode(200);
            $response->setMessage('User found.');

            return $response;
        } catch (\Exception $e) {

            $response = new ResponseResource($request);
            $response->setHttpCode(400);
            $response->setMessage($e->getMessage());

            return $response->response()->setStatusCode($response->getHttpCode());
        }
    }

    public function update($id, Request $request){

        try {

            $validator = validator($request->only('name'), [
                'name' => 'required|string',
            ]);

            if ($validator->fails()) {
                throw new InvalidParameterException('Unable to update Test. '.$validator->errors()->first());
            }

            $response = new ResponseResource([]);
            $response->setHttpCode(200);
            $response->setMessage('Updated.');

            return $response;
        } catch (\Exception $e) {

            $response = new ResponseResource($request);
            $response->setHttpCode(400);
            $response->setMessage($e->getMessage());

            return $response->response()->setStatusCode($response->getHttpCode());
        }
    }
}
