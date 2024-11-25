<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\User; // <- Importación de User 
use App\Models\UserRole;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // Obtener todas las organizaciones de la base de datos
            $users = User::select([
                'iduser as id',
                DB::raw("CONCAT(grado, ' ', appaterno, ' ', apmaterno, ' ', nombres) as name"), // Concatenar las columnas
                'email',
                'celular',
                'usuario',
                DB::raw("TO_CHAR(last_login, 'DD/MM/YYYY HH24:MI:SS') as lastlogin"), // Formatear fecha de último login
                DB::raw("CASE WHEN status = true THEN 'Activo' ELSE 'Inactivo' END as status"), // Transformar estado
                DB::raw("TO_CHAR(created_at, 'DD/MM/YYYY HH24:MI:SS') as fcreate"), // Formatear created_at
                DB::raw("TO_CHAR(updated_at, 'DD/MM/YYYY HH24:MI:SS') as fupdate")  // Formatear updated_at
            ])->get();
        
            // Verificar si no se encontraron puesto
            if ($users->isEmpty()) {
                // Si no se encuentra ninguna organización, retornar un error 404
                throw new \Illuminate\Database\Eloquent\ModelNotFoundException('No se encontraron puestos.');
            }
        
            // Retornar una respuesta exitosa con los datos encontrados
            return response()->json([
                'status' => true,
                'message' => 'Lista de usuarios obtenida correctamente.',
                'data' => $users
            ], 200);
        
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Manejar el caso cuando no se encuentran organizaciones (404)
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 404);
        } catch (\Exception $e) {
            // Manejo de errores generales (500)
            return response()->json([
                'status' => false,
                'message' => 'Error al obtener las usuarios: ' . $e->getMessage()
            ], 500);
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
    public function store(StoreUserRequest $request)
    {
        try {
            $user = User::create(array_merge(
                $request->validated()
            ));

            return response()->json([
                'status' => true,
                'message' => 'Usuario registrado correctamente',
                'data'=> $request->all()
            ], 200);
            
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500); 
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        try {
            // Buscar el usuario por ID
            $user = User::findOrFail($id);
    
            // Retornar una respuesta exitosa con los detalles de la organización
            return response()->json([
                'status' => true,
                'message' => 'Usuario encontrado.',
                'data' => $user
            ], 200); // Código de estado 200 para una solicitud exitosa
    
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Si no se encuentra la organización, retornar un error 404
            return response()->json([
                'status' => false,
                'message' => 'Usuario encontrado.'
            ], 404);
        } catch (\Exception $e) {
            // Manejo de errores generales
            return response()->json([
                'status' => false,
                'message' => 'Error al obtener el usuario: ' . $e->getMessage()
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
    public function update(StoreUserRequest $request, int $id){
        try {
            // Buscar el usuario por iduser
            $user = User::where('iduser', $id)->firstOrFail();

            // Validar los datos del request
            $user->update($request->validated());

            // Verificar si se proporcionó un valor de contraseña no vacío
                if ($request->filled('password')) {
                    $validatedData['password'] = bcrypt($request->password);
                } else {
                    // Si el password está vacío, eliminamos el campo para evitar actualizarlo con un valor vacío
                    unset($validatedData['password']);
                }

            // Actualizar el usuario con los datos validados
            $user->update($validatedData);

            return response()->json([
                'status' => true,
                'message' => 'Usuario actualizado correctamente',
                'data' => $user
            ], 200); // Código de estado 200 para éxito
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Usuario no encontrado'
            ], 404); // Código de estado 404 para no encontrado
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Error al actualizar el usuario: ' . $th->getMessage()
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
    /**
     * Remove the specified resource from storage.
    */
    public function asignarRoles(Request $request){
        try {
            // Validar los datos del request
            $validatedData = $request->validate([
                'iduser' => 'required|numeric',
                'idrol' => 'required|numeric'
            ]);

            // Obtener el iduser del request
            $id = $validatedData['iduser'];

            // Buscar los roles por usuario y eliminarlos
            UserRole::where('iduser', $id)->delete();

            // Crear el nuevo rol para el usuario
            $userRole = UserRole::create([
                'iduser' => $id,
                'idrol' => $validatedData['idrol']
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Rol asignado correctamente',
                'data' => $userRole
            ], 200); // Código de estado 200 para éxito
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Error al registrar el rol de usuario: ' . $th->getMessage()
            ], 500); // Código de estado 500 para errores generales
        }
    }

}
