<?php

namespace App\Http\Controllers\API;

use App\Models\HealthData;
use App\Http\Controllers\Controller;
use App\Http\Resources\HealthDataResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Response;

class HealthDataController extends Controller
{
    

    /**
     * Display the specified resource.
     *
     * @param  \App\HealthData  $HealthData
     * @return \Illuminate\Http\Response
     */
    public function show(HealthData $poi)
    {
        $data = [
            'poi' => HealthData::poi($poi)->first()
        ];

        return Response::json($data);

    }

   

   
}