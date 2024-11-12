<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRolesRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\Roles; // <- Importación de User
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            // Obtener todos los usuarios de la base de datos
            $response = Roles::all();
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
    public function store(StoreRolesRequest $request)
    {
        try {
            // Crea el usuario utilizando los datos validados del request
            $user = Roles::create(array_merge(
                $request->validated()
            ));

            return response()->json([
                'status' => true,
                'message' => 'Rol de usuario registrado correctamente',
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
    public function update(Request $request, int $id)
    {
        try {
            // Buscar el usuario por iduser
            $response = Roles::where('idrol', $id)->firstOrFail();

            // Validar los datos del request
            $validatedData = $request->validate([
                'rol' => 'sometimes|string|min:3|max:30|unique:roles,rol,' . $id . ',idrol', 
            ]);
            // Actualizar el usuario con los datos validados
            $response->update($validatedData);

            return response()->json([
                'status' => true,
                'message' => 'Rol de Usuario actualizado correctamente',
                'data' => $response
            ], 200); // Código de estado 200 para éxito
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Rol de Usuario no encontrado'
            ], 404); // Código de estado 404 para no encontrado
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Error al actualizar el rol de usuario: ' . $th->getMessage()
            ], 500); // Código de estado 500 para errores generales
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
