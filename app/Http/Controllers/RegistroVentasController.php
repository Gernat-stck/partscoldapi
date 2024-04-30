<?php

namespace App\Http\Controllers;

use App\Models\RegistroVentas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

const REQUIRED_STRG = 'required|string';
const REQUIRED_NUMERIC = 'required|numeric';
class RegistroVentasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ventas = RegistroVentas::all();
        return response()->json($ventas);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre_cliente' => REQUIRED_STRG,
            'direccion' => REQUIRED_STRG,
            'numero_telefono' => REQUIRED_STRG,
            'email' => 'required|string|email',
            'documento' => REQUIRED_STRG,
            'total' => REQUIRED_NUMERIC,
            'iva' => REQUIRED_NUMERIC,
            'subtotal' => REQUIRED_NUMERIC,
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $venta = RegistroVentas::create($request->all());

        return response()->json($venta, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RegistroVentas  $venta
     * @return \Illuminate\Http\Response
     */
    public function show(RegistroVentas $venta)
    {
        return response()->json($venta);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RegistroVentas  $venta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RegistroVentas $venta)
    {
        $validator = Validator::make($request->all(), [
            'nombre_cliente' => REQUIRED_STRG,
            'direccion' => REQUIRED_STRG,
            'numero_telefono' => REQUIRED_STRG,
            'email' => 'required|string|email',
            'documento' => REQUIRED_STRG,
            'total' => REQUIRED_NUMERIC,
            'iva' => REQUIRED_NUMERIC,
            'subtotal' => REQUIRED_NUMERIC,
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $venta->update($request->all());

        return response()->json($venta, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RegistroVentas  $venta
     * @return \Illuminate\Http\Response
     */
    public function destroy(RegistroVentas $venta)
    {
        $venta->delete();

        return response()->json(null, 204);
    }
}
