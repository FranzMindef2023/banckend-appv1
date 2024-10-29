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

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // Obtener todos los usuarios de la base de datos
            $users = User::all();
    
            return response()->json([
                'status' => true,
                'message' => 'Lista de usuarios obtenida correctamente.',
                'data' => $users
            ], 200); // Código de estado 200 para éxito
        } catch (\Throwable $th) {
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
    public function store(StoreUserRequest $request)
    {
        try {
            // Crea el usuario utilizando los datos validados del request
            $user = User::create(array_merge(
                $request->validated(), // Usa los datos validados del request
                ['password' => bcrypt($request->password)]
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
            ], 500); // Código de estado 500 para errores generales
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            // Buscar el usuario por ID
            $user = User::findOrFail($id);

            return response()->json([
                'status' => true,
                'message' => 'Usuario encontrado.',
                'data' => $user
            ], 200); // Código de estado 200 para éxito
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Usuario no encontrado.'
            ], 404); // Código de estado 404 para no encontrado
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Error al obtener el usuario: ' . $th->getMessage()
            ], 500); // Código de estado 500 para errores generales
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
    public function update(Request $request, string $id){
        try {
            // Buscar el usuario por iduser
            $user = User::where('iduser', $id)->firstOrFail();

            // Validar los datos del request
            $validatedData = $request->validate([
                'usuario' => 'sometimes|string|max:255|unique:users,usuario,' . $id . ',iduser', // Cambiar a iduser
                'email' => 'sometimes|email|max:255|unique:users,email,' . $id . ',iduser', // Cambiar a iduser
                'ci' => 'sometimes|string|unique:users,ci,' . $id . ',iduser', // Cambiar a iduser
                'password' => 'sometimes|string|min:8', // Asegúrate de validar la contraseña si se proporciona
            ]);

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
