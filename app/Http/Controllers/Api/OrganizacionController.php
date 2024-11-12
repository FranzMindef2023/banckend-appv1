<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreOrganizacionRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\Organizacion; 
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OrganizacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            // Obtener todos los usuarios de la base de datos
            $response = Organizacion::all();
            return response()->json([
                'status' => true,
                'message' => 'Datos de entrada no válidos.',
                'data' => $response // Retornar los errores de validación
            ], 200); // Código de estado 422 para errores de validación
        }catch(\Throwable $th){
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500); // Código de estado 500 para errores generales
        }
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
    public function store(StoreOrganizacionRequest $request)
    {
        try {
            // $user = Organizacion::create(array_merge(
            //     $request->validated()
            // ));

            return response()->json([
                'status' => true,
                'message' => 'Organizacion registrado correctamente',
                'data'=> $request->all()
            ], 200);
            
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500); // Código de estado 500 para errores generales
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        try {
            // Buscar la organización por su ID
            $organizacion = Organizacion::where('idorg', $id)->firstOrFail();
    
            // Retornar una respuesta exitosa con los detalles de la organización
            return response()->json([
                'status' => true,
                'message' => 'Organización encontrada',
                'data' => $organizacion
            ], 200); // Código de estado 200 para una solicitud exitosa
    
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Si no se encuentra la organización, retornar un error 404
            return response()->json([
                'status' => false,
                'message' => 'Organización no encontrada'
            ], 404);
        } catch (\Exception $e) {
            // Manejo de errores generales
            return response()->json([
                'status' => false,
                'message' => 'Error al obtener la organización: ' . $e->getMessage()
            ], 500);
        }
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
    public function update(StoreOrganizacionRequest $request, string $id)
    {
        try {
            // Buscar la organización por su ID
            $organizacion = Organizacion::where('idorg', $id)->firstOrFail();
    
            // Actualizar los datos de la organización con los datos validados
            $organizacion->update($request->validated());
    
            // Retornar una respuesta exitosa con los datos actualizados
            return response()->json([
                'status' => true,
                'message' => 'Organización actualizada correctamente',
                'data' => $organizacion
            ], 200); // Código de estado 200 para una actualización exitosa
    
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Si no se encuentra el ID, retornamos un error 404
            return response()->json([
                'status' => false,
                'message' => 'Organización no encontrada'
            ], 404);
        } catch (\Exception $e) {
            // Manejo de errores generales
            return response()->json([
                'status' => false,
                'message' => 'Error al actualizar la organización: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            // Buscar la organización por su ID
            $organizacion = Organizacion::where('idorg', $id)->firstOrFail();
    
            // Eliminar la organización encontrada
            $organizacion->delete();
    
            // Retornar una respuesta exitosa
            return response()->json([
                'status' => true,
                'message' => 'Organización eliminada correctamente'
            ], 200); // Código de estado 200 para una eliminación exitosa
    
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Si no se encuentra la organización, retornar un error 404
            return response()->json([
                'status' => false,
                'message' => 'Organización no encontrada'
            ], 404);
        } catch (\Exception $e) {
            // Manejo de errores generales
            return response()->json([
                'status' => false,
                'message' => 'Error al eliminar la organización: ' . $e->getMessage()
            ], 500);
        }
    }
}
