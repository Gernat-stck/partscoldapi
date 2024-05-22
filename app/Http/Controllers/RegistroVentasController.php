<?php

namespace App\Http\Controllers;

use App\Models\RegistroVentas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


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
            '*.nombre_cliente' => REQUIRED_STRG,
            '*.direccion' => REQUIRED_STRG,
            '*.numero_telefono' => REQUIRED_STRG,
            '*.email' => 'required|string|email',
            '*.documento' => REQUIRED_STRG,
            '*.total' => REQUIRED_NUMERIC,
            '*.iva' => REQUIRED_NUMERIC,
            '*.subtotal' => REQUIRED_NUMERIC,
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $createdRegistro = [];

        foreach ($request->all() as $value) {
            $venta = RegistroVentas::create($value);
            $createdRegistro[] = $venta;
        }

        return response()->json($createdRegistro, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RegistroVentas  $venta
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $terminoBusqueda = $request->query('termino');
        $campos = ['product_name', 'codigo_producto'];

        $query = RegistroVentas::query();

        foreach ($campos as $campo) {
            $query->orWhere($campo, 'LIKE', "%{$terminoBusqueda}%");
        }

        $resultados = $query->get();

        return response()->json($resultados);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RegistroVentas  $venta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            '*.id' => 'required|exists:registro_ventas,id',
            '*.nombre_cliente' => REQUIRED_STRG,
            '*.direccion' => REQUIRED_STRG,
            '*.numero_telefono' => REQUIRED_STRG,
            '*.email' => 'required|string|email',
            '*.documento' => REQUIRED_STRG,
            '*.total' => REQUIRED_NUMERIC,
            '*.iva' => REQUIRED_NUMERIC,
            '*.subtotal' => REQUIRED_NUMERIC,
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $updatedVentas = [];

        foreach ($request->all() as $value) {
            $currentVenta = RegistroVentas::findOrFail($value['id']);
            $currentVenta->update($value);
            $updatedVentas[] = $currentVenta;
        }

        return response()->json($updatedVentas, 200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RegistroVentas  $venta
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        $registro = RegistroVentas::findOrFail($id);
        $registro->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }
}
