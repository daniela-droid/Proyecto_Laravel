<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\reportes_admins; // Tu modelo real
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\reportes_docentes;
class ReportesAdmController extends Controller
{ 
    public function generarPdf($tipo, $id)
{
   // Obtenemos el usuario autenticado
    $user = auth()->user();

    // Si el usuario es Admin, busca en la tabla de reportes_admins
    if ($user->rol === 'admin') { 
        $reporte = reportes_admins::findOrFail($id);
        $vista = 'reportesadm.pdf';
    } 
    // Si no, busca en la tabla de reportes_docentes
    else {
        $reporte = reportes_docentes::findOrFail($id);
        $vista = 'reportes.pdf';
    }

    // Generamos el PDF con la vista y el modelo detectado
    $pdf = Pdf::loadView($vista, compact('reporte'));
    
    return $pdf->download('Reporte_'.$reporte->id.'.pdf');
}
}