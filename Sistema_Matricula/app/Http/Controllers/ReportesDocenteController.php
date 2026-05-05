<?php

namespace App\Http\Controllers;

use App\Models\reportes_docentes;
use Illuminate\Http\Request;

use App\Models\Docentes;

use App\Models\Estudiante;
class ReportesDocenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reportes=reportes_docentes::with(['docentes','estudiantes'])->get();
        return view('reportes.index',compact('reportes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $docentes=Docentes::all();
        $estudiantes=Estudiante::all();
        return view('reportes.create',compact('docentes','estudiantes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
          
            'id_estudiante'=>'required|exists:estudiantes,id',
            'titulo'=>'required|string|max:255',
            'descripcion'=>'required|string|min:10|max:1000',
            'tipo'=>'required:in:conducta,rendimiento,asistencia'

        ]);
          $docente = auth()->user()->docentes;
        reportes_docentes::create([
            'id_docente'=>$docente->id,
             'id_estudiante' => $request->id_estudiante,
            'titulo'=>$request->titulo,
            'descripcion'=>$request->descripcion,
            'tipo'=>$request->tipo
        ]);
        return redirect()->route('reportes.index')->with('success','creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(reportes_docentes $reporte)
    {
        
        return view('reportes.show',compact('reporte'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(reportes_docentes $reporte)
    {
        $docentes=Docentes::all();
        $estudiantes=Estudiante::all();
        return view('reportes.edit',compact('reporte','docentes','estudiantes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, reportes_docentes $reporte)
    {
         $request->validate([
            'id_estudiante'=>'required|exists:estudiantes,id',
            'titulo'=>'required|string|max:255',
            'descripcion'=>'required|string|min:10|max:1000',
            'tipo'=>'required:in:conducta,rendimiento,asistencia'

        ]);
       
        $reporte->update([
            'id_estudiante' => $request->id_estudiante,
             'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'tipo' => $request->tipo
        ]);
        return redirect()->route('reportes.index')->with('success','creado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(reportes_docentes $reporte)
    {
        $reporte->delete();
        return redirect()->route('reportes.index')->with('success','creado correctamente');
    }
}
