<?php

namespace App\Http\Controllers;

use App\Models\Centros_educativos;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CentrosEducativosController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'centro' => Centros_educativos::principal(),
        ]);
    }

    public function create()
    {
        return redirect()->back();
    }

    public function store(Request $request)
    {
        $centro = Centros_educativos::principal();
        $data = $this->validatedData($request, $centro?->id);

        $centro = $centro
            ? tap($centro)->update($data)
            : Centros_educativos::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Centro educativo guardado correctamente.',
            'centro' => $centro,
        ]);
    }

    public function show(Centros_educativos $centros_educativos)
    {
        return response()->json([
            'success' => true,
            'centro' => $centros_educativos,
        ]);
    }

    public function edit(Centros_educativos $centros_educativos)
    {
        return redirect()->back();
    }

    public function update(Request $request, Centros_educativos $centros_educativos)
    {
        $centros_educativos->update($this->validatedData($request, $centros_educativos->id));

        return response()->json([
            'success' => true,
            'message' => 'Centro educativo actualizado correctamente.',
            'centro' => $centros_educativos->fresh(),
        ]);
    }

    public function destroy(Centros_educativos $centros_educativos)
    {
        return response()->json([
            'success' => false,
            'message' => 'El centro educativo es información institucional y no se elimina desde este controlador.',
        ], 403);
    }

    private function validatedData(Request $request, ?int $centroId = null): array
    {
        return $request->validate([
            'codigo' => [
                'required',
                'string',
                'max:50',
                Rule::unique('centros_educativos', 'codigo')->ignore($centroId),
            ],
            'nombre' => 'required|string|max:150',
            'departamento' => 'nullable|string|max:100',
            'municipio' => 'nullable|string|max:100',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:30',
            'correo' => 'nullable|email|max:120',
            'director' => 'nullable|string|max:150',
        ]);
    }
}
