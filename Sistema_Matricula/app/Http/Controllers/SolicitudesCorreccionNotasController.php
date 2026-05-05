<?php

namespace App\Http\Controllers;

use App\Models\SolicitudCorreccionNota;
use Illuminate\Http\Request;

class SolicitudesCorreccionNotasController extends Controller
{
    public function index()
    {
        $solicitudes = SolicitudCorreccionNota::with([
            'docente',
            'nota.matriculas.estudiantes',
            'nota.horarios.asignatura',
            'nota.horarios.grupo.grados',
            'nota.cortes',
            'admin',
        ])
            ->orderByRaw("CASE WHEN estado = 'pendiente' THEN 0 ELSE 1 END")
            ->latest()
            ->get();

        return view('admin.solicitudes_notas.index', compact('solicitudes'));
    }

    public function aprobar(Request $request, SolicitudCorreccionNota $solicitud)
    {
        $request->validate([
            'respuesta_admin' => 'nullable|string|max:500',
        ]);

        if ($solicitud->estado !== 'pendiente') {
            return back()->with('error', 'Esta solicitud ya fue atendida.');
        }

        // La aprobación es temporal y de un solo uso: cuando el docente corrige, vuelve a bloquearse.
        $solicitud->update([
            'estado' => 'aprobada',
            'id_admin' => auth()->id(),
            'respuesta_admin' => $request->respuesta_admin,
            'aprobada_hasta' => now()->addDays(2),
        ]);

        return back()->with('success', 'Solicitud aprobada. El docente podrá corregir esa nota una sola vez.');
    }

    public function rechazar(Request $request, SolicitudCorreccionNota $solicitud)
    {
        $request->validate([
            'respuesta_admin' => 'nullable|string|max:500',
        ]);

        if ($solicitud->estado !== 'pendiente') {
            return back()->with('error', 'Esta solicitud ya fue atendida.');
        }

        $solicitud->update([
            'estado' => 'rechazada',
            'id_admin' => auth()->id(),
            'respuesta_admin' => $request->respuesta_admin,
        ]);

        return back()->with('success', 'Solicitud rechazada correctamente.');
    }
}
