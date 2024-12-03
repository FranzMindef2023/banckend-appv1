<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\Statuscv; // <- Importación de User
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class EstadocvController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // Obtener todos los registros de la tabla statuscv de la base de datos
            $statuscv = Statuscv::select([
                'idcv as id',
                'name',
                DB::raw("CASE WHEN status = true THEN 'Activo' ELSE 'Inactivo' END as status"),
                DB::raw("TO_CHAR(created_at, 'DD/MM/YYYY HH24:MI:SS') as fcreate"), // Formato dd/MM/YYYY HH24:MI:SS para created_at
                DB::raw("TO_CHAR(updated_at, 'DD/MM/YYYY HH24:MI:SS') as fupdate")  // Formato dd/MM/YYYY HH24:MI:SS para updated_at
            ])->get();

            // Verificar si no se encontraron registros
            if ($statuscv->isEmpty()) {
                // Si no se encuentra ningún registro, retornar un error 404
                throw new \Illuminate\Database\Eloquent\ModelNotFoundException('No se encontraron registros en statuscv.');
            }

            // Retornar una respuesta exitosa con los datos transformados
            return response()->json([
                'status' => true,
                'message' => 'Registros encontrados en statuscv',
                'data' => $statuscv
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Manejar el caso cuando no se encuentran registros (404)
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 404);
        } catch (\Exception $e) {
            // Manejo de errores generales (500)
            return response()->json([
                'status' => false,
                'message' => 'Error al obtener los registros de statuscv: ' . $e->getMessage()
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
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
