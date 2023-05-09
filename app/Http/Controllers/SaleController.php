<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Commerce;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class SaleController extends BaseController
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'device_id' => 'required|exists:devices,id',
            'payment' => 'required|in:DEBITO,CREDITO,EFECTIVO',
            'status' => 'required|in:ACEPTADA,ANULADA',
            'amount' => 'required|numeric'
        ]);

        if($validator->fails()){
            return $this->sendError('Error', $validator->errors());
        }

        $data = $request->all();
        $sale = Sale::create($data);

        $Add_cod = Sale::find($sale->id);
        $Add_cod->cod = Hash::make($Add_cod->id);
        $Add_cod->save();

        $this->addPoints($sale->id);

        return $this->sendResponse($Add_cod, 'Se ha agregado satisfactoriamente.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale) : JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:sales,id',
            'cod' => 'required|exists:sales,cod'
        ]);

        if($validator->fails()){
            return $this->sendError('Error', $validator->errors());
        }

        $data = $request->all();
        $sale = Sale::find($data['id']);

        if($sale->status == 'ANULADA')
            return $this->sendError('Error', 'La venta ya se encuentra anulada');

        if(Hash::check($data['id'], $data['cod']))
        {
            $sale->status = 'ANULADA';
            $sale->save();

            $this->removePoints($sale->id);

            return $this->sendResponse($sale, 'Venta anulada.');
        }
        else
            return $this->sendError('Error', 'El código no coincide');

    }

    public function searchByPayment(Request $request) : JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'payment' => 'required|in:DEBITO,CREDITO,EFECTIVO'
        ]);

        if($validator->fails()){
            return $this->sendError('Error', $validator->errors());
        }

        $data = $request->all();

        $result = Sale::where('payment', $data['payment'])->get()->makeHidden(['cod']);

        return $this->sendResponse($result, []);

    }

    public function searchByStatus(Request $request) : JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:ACEPTADA,ANULADA'
        ]);

        if($validator->fails()){
            return $this->sendError('Error', $validator->errors());
        }

        $data = $request->all();

        $result = Sale::where('status', $data['status'])->get()->makeHidden(['cod']);

        return $this->sendResponse($result, []);

    }

    public function searchByDates(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'start' => 'date_format:Y-m-d|required',
            'end' => 'date_format:Y-m-d|required'
        ]);

        if($validator->fails()){
            return $this->sendError('Error', $validator->errors());
        }

        $data = $request->all();

        $results = Sale::whereBetween('created_at', [$request['start'], $request['end']])->latest()->get()->makeHidden(['cod']);

        return $this->sendResponse($results, []);
    }

}
