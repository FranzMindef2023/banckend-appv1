<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RolesController;
use App\Http\Controllers\Api\AuthController;

use App\Http\Controllers\Api\OrganizacionController;
use App\Http\Controllers\Api\NovedadesController;
use App\Http\Controllers\Api\PersonasController;
use App\Http\Controllers\Api\PuestosController;
use App\Http\Controllers\Api\TipoNovedadesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
// Route::apiResource('/usuarios', UserController::class);
// Route::apiResource('/rolsUser', RolesController::class);
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('login', [AuthController::class,'login']);
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('register', [AuthController::class,'register']);
    Route::post('me', [AuthController::class,'me']);
    
});

Route::post('roldeusuario', [UserController::class,'asignarRoles']);

Route::middleware(['jwt.verify'])->group(function () {
    Route::apiResource('usuarios', UserController::class);
    Route::apiResource('roles', RolesController::class);
    Route::apiResource('organizacion', OrganizacionController::class);
    Route::get('organizacion/{id}/hijos', [OrganizacionController::class, 'obtenerHijos']);

    Route::apiResource('puestos', PuestosController::class);
    Route::apiResource('tiponovedades', TipoNovedadesController::class);
    Route::apiResource('persona', PersonasController::class);
});