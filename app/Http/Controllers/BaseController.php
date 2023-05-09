<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Commerce;
use App\Models\Device;

class BaseController extends Controller
{

    public function sendResponse($result, $message)
    {
    	$response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }

    public function sendError($error, $errorMessages = [], $code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $error,
        ];


        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }

    public function addPoints($sale_id, $point = 10)
    {
        $sale = Sale::findOrFail($sale_id);
        $device = Device::find($sale->device_id);
        $commerce = Commerce::find($device->commerce_id);

        $commerce->points = $commerce->points + $point;
        $commerce->save();
    }

    public function removePoints($sale_id, $point = 10)
    {
        $sale = Sale::findOrFail($sale_id);
        $device = Device::find($sale->device_id);
        $commerce = Commerce::find($device->commerce_id);

        $commerce->points = $commerce->points - $point;
        $commerce->save();
    }
}
