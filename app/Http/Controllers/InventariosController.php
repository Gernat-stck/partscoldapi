<?php

namespace App\Http\Controllers;

use App\Models\Inventarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class InventariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inventario = Inventarios::all();
        return response()->json($inventario, 200);
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
            'product_name' => 'required|string',
            'codigo_producto' => 'required|string',
            'descripcion' => 'required|string',
            'cantidad_stock' => 'required|integer',
            'img_product' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'precio_producto' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $inventario_data = $request->all();

        // Procesar la imagen si se cargó
        if ($request->hasFile('img_product')) {
            $image = $request->file('img_product');
            $image_name = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/images', $image_name);
            $inventario_data['img_product'] = '/storage/images/' . $image_name;
        }

        $inventario = Inventarios::create($inventario_data);

        return response()->json($inventario, 201);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inventarios  $inventario
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $terminoBusqueda = $request->query('termino');
        $campos = ['product_name', 'codigo_producto', 'descripcion'];

        $query = Inventarios::query();

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
     * @param  \App\Models\Inventarios  $inventario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $inventario = Inventarios::findOrFail($id);

        $validatedData = $request->validate([
            'product_name' => 'required|string',
            'codigo_producto' => 'required|string',
            'descripcion' => 'required|string',
            'cantidad_stock' => 'required|integer',
            'img_product' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'precio_producto' => 'required|numeric',
        ]);
        if ($request->hasFile('img_product')) {
            // Delete the existing image from storage
            Storage::delete($inventario->img_product);

            // Store the new image in storage
            $validatedData['img_product'] = $request->file('img_product')->store('images');
        }

        $inventario->update($validatedData);

        return response()->json($inventario, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventarios  $inventario
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        $inventario = Inventarios::findOrFail($id);
        $inventario->delete();
        return response()->json(['message' => 'Eliminado con éxito']);
    }
}

