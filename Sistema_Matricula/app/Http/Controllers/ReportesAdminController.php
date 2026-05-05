<?php

namespace App\Http\Controllers;

use App\Models\reportes_admins;
use Illuminate\Http\Request;
use App\Models\Admin;

class ReportesAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    //   dd(reportes_admins::all());
        $reportesadm=reportes_admins::with(['admin.usuarios'])->get();
        return view('reportesadm.index',compact('reportesadm'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $admin=Admin::all();
        return view('reportesadm.create',compact('admin'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    //    return response()->json($request->all());
        $request->validate([
         'titulo'=>'required|string|max:255',
            'descripcion'=>'required|string|min:10|max:1000',
            'categoria'=>'required|in:sistema,infraestructura,personal,otros'
        ]);
        //con esto pasamos el admin que ya esta logueado
        $adminId = auth()->user()->admin->id;

        reportes_admins::create([
            'id_admin'=>$adminId,
          'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'categoria' => $request->categoria
        ]);
    
        return redirect()->route('reportesadm.index')->with('success','creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(reportes_admins $reporte)
    {
        return view('reportesadm.show',compact('reporte'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(reportes_admins $reporte)
    {
            //  $admin=Admin::all();
            return view('reportesadm.edit',compact('reporte'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, reportes_admins $reporte)
    {
         $request->validate([
           'titulo'=>'required|string|max:255',
            'descripcion'=>'required|string|min:10|max:1000',
            'categoria'=>'required|in:sistema,infraestructura,personal,otros'
        ]);
        
        $reporte->update([
             'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'categoria' => $request->categoria
        ]);
        return redirect()->route('reportesadm.index')->with('success','actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
              $reporte = reportes_admins::findOrFail($id);

            $reporte->delete();
            
            if ($reporte->id_admin != auth()->user()->admin->id_admin) {
             //abort(403);
              return redirect()->route('reportesadm.index');
                }

          //  return redirect()->route('reportesadm.index');
            // dd($reporte->id);
            // $reporte->delete();

            // return redirect()->route('reportesadm.index')->with('success','eliminado correctamente');
               
    }
}
