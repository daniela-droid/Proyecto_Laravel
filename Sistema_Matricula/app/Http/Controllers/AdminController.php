<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Usuario;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins=Admin::with(['usuarios'])->get();
        return view('admins.index',compact('admins'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $usuarios=Usuario::all();
        return view('admins.create',compact('usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $request->validate([
        'id_usuarios'=>'required|exists:usuarios,id',
        'Nombre'=>'required|string|max:80',
        'Apellido'=>'required|string|max:80',
        'Cargo'=>'required|string|max:180'
            
        ]);
        Admin::create($request->all());
 return redirect()->route('admins.index')->with('secces','admin creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(admin $admin)
    {
        return view('admins.show',compact('admin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(admin $admin)
    {
         $usuarios=Usuario::all();
         return view('admins.edit',compact('admin','usuarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, admin $admin)
    {
        $request->validate([
        'id_usuarios'=>'required|exists:usuarios,id|unique:admins,id_usuarios,'. $admin->id,
        'Nombre'=>'required|string|max:80',
        'Apellido'=>'required|string|max:80',
        'Cargo'=>'required|string|max:180'
            
        ]);
        $admin->update($request->all());
        
    return redirect()->route('admins.index')->with('secces','admin actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(admin $admin)
    {
        $admin->delete();

    return redirect()->route('admins.index')->with('secces','admin eliminado correctamente');
    }
}
