<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;

class DeviceController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index() : JsonResponse
    {
        $device = Device::get();

        return $this->sendResponse($device, []);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'commerce_id' => 'required|exists:commerces,id',
            'name' => 'required',
            'model' => 'required',
            'ip' => 'required|ip'
        ]);

        if($validator->fails()){
            return $this->sendError('Error', $validator->errors());
        }

        $data = $request->all();
        $device = Device::create($data);

        return $this->sendResponse($device, 'Se ha agregado satisfactoriamente.');
    }

    public function update(Request $request, $id) : JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'model' => 'required',
            'ip' => 'required|ip'
        ]);

        if($validator->fails()){
            return $this->sendError('Error', $validator->errors());
        }

        $data = $request->all();

        $device = Device::findOrFail($id)->update($data);

        return $this->sendResponse([], 'Se ha modificado satisfactoriamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) : JsonResponse
    {
        $device =  Device::findOrFail($id);
        if($device->delete())
            return $this->sendResponse($device, 'Se ha eliminado satisfactoriamente.');
    }
}
