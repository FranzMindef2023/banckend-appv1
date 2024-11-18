<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreNovedadesRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\Novedades; 
use Illuminate\Database\Eloquent\ModelNotFoundException;

class NovedadesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNovedadesRequest $request)
    {
        try {
            $response = Novedades::create(array_merge(
                $request->validated()
            ));

            return response()->json([
                'status' => true,
                'message' => 'Novedad registrada correctamente.',
                'data'=> $request->all()
            ], 200);
            
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Error al registrar la novedad: ' . $th->getMessage()
            ], 500); // Código de estado 500 para errores generales
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreNovedadesRequest $request, string $id)
    {
        try {
            // Buscar la novedad por su ID
            $novedad = Novedades::findOrFail($id);

            // Actualizar los campos con los datos validados
            $novedad->update($request->validated());

            return response()->json([
                'status' => true,
                'message' => 'Novedad actualizada correctamente.',
                'data' => $novedad
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Si la novedad no se encuentra, devolver un error 404
            return response()->json([
                'status' => false,
                'message' => 'Novedad no encontrada.'
            ], 404);
        } catch (\Throwable $th) {
            // Manejo de otros errores
            return response()->json([
                'status' => false,
                'message' => 'Error al actualizar la novedad: ' . $th->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Buscar la novedad por su ID
            $novedad = Novedades::findOrFail($id);
    
            // Marcar la novedad como inactiva en lugar de eliminarla
            $novedad->activo = false;
            $novedad->save();
    
            return response()->json([
                'status' => true,
                'message' => 'Novedad desactivada correctamente.',
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Si la novedad no se encuentra, devolver un error 404
            return response()->json([
                'status' => false,
                'message' => 'Novedad no encontrada.',
            ], 404);
        } catch (\Throwable $th) {
            // Manejo de otros errores
            return response()->json([
                'status' => false,
                'message' => 'Error al desactivar la novedad: ' . $th->getMessage()
            ], 500);
        }
    }
}
