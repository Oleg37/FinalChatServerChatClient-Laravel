<?php

use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * Ruta para la información de nuestros mensajes.
 */

Route::resource("message", MessageController::class, ['except' => ['create', 'edit']]);

/**
 * Ruta para eliminar toda la información de la columna de los mensajes.
 */

Route::delete("destroyAllMSG", [MessageController::class, 'destroyAllMSG'])->name("destroyAllMSG");

/**
 * Ruta para obtener la información con sus respectivos sender y receiver.
 */

Route::get("getPrivateMessage/{userSend}/{userReceiver}", [MessageController::class, 'getPrivateMessage'])->name('getPrivateMessage');
