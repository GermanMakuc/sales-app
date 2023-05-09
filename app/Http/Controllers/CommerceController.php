<?php

namespace App\Http\Controllers;

use App\Models\Commerce;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;

class CommerceController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index() : JsonResponse
    {
        $commerce = Commerce::get();

        return $this->sendResponse($commerce, []);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'rut' => 'required',
            'name' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Error', $validator->errors());
        }

        $data = $request->all();
        $commerce = Commerce::create($data);

        return $this->sendResponse($commerce, 'Se ha agregado satisfactoriamente.');
    }

    public function update(Request $request, $id) : JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'rut' => 'required',
            'name' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Error', $validator->errors());
        }

        $data = $request->all();
        $commerce = Commerce::findOrFail($id)->update($data);

        return $this->sendResponse([], 'Se ha modificado satisfactoriamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) : JsonResponse
    {
        $commerce =  Commerce::findOrFail($id);
        if($commerce->delete())
            return $this->sendResponse($commerce, 'Se ha eliminado satisfactoriamente.');
    }
}
