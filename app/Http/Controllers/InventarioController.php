<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

const REQUIRED_STRG = 'required|string';

class InventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inventario = Inventario::all();
        return response()->json([$inventario], 200);
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
            '*.product_name' => REQUIRED_STRG,
            '*.codigo_producto' => REQUIRED_STRG,
            '*.descripcion' => REQUIRED_STRG,
            '*.cantidad_stock' => 'required|integer',
            '*.img_product' => 'nullable|string',
            '*.precio_producto' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $createdInventories = [];

        foreach ($request->all() as $InventarioData) {
            $inventario = Inventario::create($InventarioData);
            $createdInventories[] = $inventario;
        }

        return response()->json($createdInventories, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inventario  $Inventario
     * @return \Illuminate\Http\Response
     */
    public function show(Inventario $inventario)
    {
        return response()->json($inventario);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inventario  $Inventario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            '*.product_name' => REQUIRED_STRG,
            '*.codigo_producto' => REQUIRED_STRG,
            '*.descripcion' => REQUIRED_STRG,
            '*.cantidad_stock' => 'required|integer',
            '*.img_product' => 'nullable|string',
            '*.precio_producto' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        foreach ($request->all() as $InventarioData) {
            $inventario = Inventario::findOrFail($InventarioData['id']);
            $inventario->update($InventarioData);
        }

        return response()->json(['message' => 'Inventories updated successfully'], 200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventario  $Inventario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inventario $inventario)
    {
        $inventario->delete();

        return response()->json(null, 204);
    }
}
