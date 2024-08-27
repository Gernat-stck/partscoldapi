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
        $validatedData = $request->validate([
            'nombre_cliente' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'numero_telefono' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'documento' => 'required|string|max:20',
            'total' => 'required|numeric',
            'iva' => 'required|numeric',
            'subtotal' => 'nullable|numeric',
            'giro' => 'required|string|max:255',
            'registro_num' => 'required|string|max:20',
            'factura' => 'required|file|mimes:pdf|max:2048',
        ]);

        // Guardar el archivo PDF
        if ($request->hasFile('factura')) {
            $path = $request->file('factura')->store('facturas', 'public');
            $validatedData['documento_path'] = $path;
        }

        $invoice = RegistroVentas::create($validatedData);

        return response()->json(['success' => true, 'invoice' => $invoice], 201);
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
