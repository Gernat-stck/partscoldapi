<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class PdfController extends Controller
{
    public function generateInvoice(Request $request)
    {
        $data = $request->all(); // Los datos que necesitas para la factura
        $pdf = PDF::loadView('invoice_template', compact('data'));
        return $pdf->download('invoice.pdf');
    }

}
