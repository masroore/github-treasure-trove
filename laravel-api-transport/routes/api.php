<?php

use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\ModelController;
use App\Http\Controllers\Api\OfficeController;
use App\Http\Controllers\Api\OfficeUserController;
use App\Http\Controllers\Api\PassengerController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\PostUserController;
use App\Http\Controllers\Api\RouteController;
use App\Http\Controllers\Api\ScheduleController;
use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\TransportController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\LoadDocumentController;
use App\Http\Controllers\LoginController;

use App\Http\Controllers\TestController;
use Illuminate\Http\Request;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::middleware('auth:api')->get('cities', [CityController::class, 'index']);
Route::middleware('auth:api')->get('cities/{id}', [CityController::class, 'show']);
Route::middleware('auth:api')->post('cities', [CityController::class, 'store']);
Route::middleware('auth:api')->put('cities/{id}', [CityController::class, 'update']);
Route::middleware('auth:api')->delete('cities/{id}', [CityController::class, 'destroy']);
Route::middleware('auth:api')->put('cities/delete/{id}', [CityController::class, 'delete']);

Route::middleware('auth:api')->get('offices', [OfficeController::class, 'index']);
Route::middleware('auth:api')->get('offices/{id}', [OfficeController::class, 'show']);
Route::middleware('auth:api')->post('offices', [OfficeController::class, 'store']);
Route::middleware('auth:api')->put('offices/{id}', [OfficeController::class, 'update']);
Route::middleware('auth:api')->delete('offices/{id}', [OfficeController::class, 'destroy']);
Route::middleware('auth:api')->put('offices/delete/{id}', [OfficeController::class, 'delete']);

Route::middleware('auth:api')->get('routes', [RouteController::class, 'index']);
Route::middleware('auth:api')->get('routes/{id}', [RouteController::class, 'show']);
Route::middleware('auth:api')->post('routes', [RouteController::class, 'store']);
Route::middleware('auth:api')->put('routes/{id}', [RouteController::class, 'update']);
Route::middleware('auth:api')->delete('routes/{id}', [RouteController::class, 'destroy']);
Route::middleware('auth:api')->put('routes/delete/{id}', [RouteController::class, 'delete']);

Route::middleware('auth:api')->get('models', [ModelController::class, 'index']);
Route::middleware('auth:api')->get('models/{id}', [ModelController::class, 'show']);
Route::middleware('auth:api')->post('models', [ModelController::class, 'store']);
Route::middleware('auth:api')->put('models/{id}', [ModelController::class, 'update']);
Route::middleware('auth:api')->delete('models/{id}', [ModelController::class, 'destroy']);
Route::middleware('auth:api')->put('models/delete/{id}', [ModelController::class, 'delete']);

Route::middleware('auth:api')->get('transports', [TransportController::class, 'index']);
Route::middleware('auth:api')->get('transports/{id}', [TransportController::class, 'show']);
Route::middleware('auth:api')->post('transports', [TransportController::class, 'store']);
Route::middleware('auth:api')->put('transports/{id}', [TransportController::class, 'update']);
Route::middleware('auth:api')->delete('transports/{id}', [TransportController::class, 'destroy']);
Route::middleware('auth:api')->put('transports/delete/{id}', [TransportController::class, 'delete']);

Route::middleware('auth:api')->get('schedules', [ScheduleController::class, 'index']);
Route::middleware('auth:api')->get('schedules/{id}', [ScheduleController::class, 'show']);
Route::middleware('auth:api')->post('schedules', [ScheduleController::class, 'store']);
Route::middleware('auth:api')->put('schedules/{id}', [ScheduleController::class, 'update']);
Route::middleware('auth:api')->delete('schedules/{id}', [ScheduleController::class, 'destroy']);
Route::middleware('auth:api')->put('schedules/delete/{id}', [ScheduleController::class, 'delete']);

Route::middleware('auth:api')->get('passengers', [PassengerController::class, 'index']);
Route::middleware('auth:api')->get('passengers/{id}', [PassengerController::class, 'show']);
Route::middleware('auth:api')->post('passengers', [PassengerController::class, 'store']);
Route::middleware('auth:api')->put('passengers/{id}', [PassengerController::class, 'update']);
Route::middleware('auth:api')->delete('passengers/{id}', [PassengerController::class, 'destroy']);
Route::middleware('auth:api')->put('passengers/delete/{id}', [PassengerController::class, 'delete']);

Route::middleware('auth:api')->get('tickets', [TicketController::class, 'index']);
Route::middleware('auth:api')->get('tickets/{id}', [TicketController::class, 'show']);
Route::middleware('auth:api')->post('tickets', [TicketController::class, 'store']);
Route::middleware('auth:api')->put('tickets/{id}', [TicketController::class, 'update']);
Route::middleware('auth:api')->delete('tickets/{id}', [TicketController::class, 'destroy']);
Route::middleware('auth:api')->put('tickets/delete/{id}', [TicketController::class, 'delete']);

Route::middleware('auth:api')->get('posts', [PostController::class, 'index']);
Route::middleware('auth:api')->get('posts/{id}', [PostController::class, 'show']);
Route::middleware('auth:api')->post('posts', [PostController::class, 'store']);
Route::middleware('auth:api')->put('posts/{id}', [PostController::class, 'update']);
Route::middleware('auth:api')->delete('posts/{id}', [PostController::class, 'destroy']);
Route::middleware('auth:api')->put('posts/delete/{id}', [PostController::class, 'delete']);

Route::middleware('auth:api')->get('post_user', [PostUserController::class, 'index']);
Route::middleware('auth:api')->get('post_user/{id}', [PostUserController::class, 'show']);
Route::middleware('auth:api')->post('post_user', [PostUserController::class, 'store']);
Route::middleware('auth:api')->put('post_user/{id}', [PostUserController::class, 'update']);
Route::middleware('auth:api')->delete('post_user/{id}', [PostUserController::class, 'destroy']);
Route::middleware('auth:api')->put('post_user/delete/{id}', [PostUserController::class, 'delete']);

Route::middleware('auth:api')->get('office_user', [OfficeUserController::class, 'index']);
Route::middleware('auth:api')->get('office_user/{id}', [OfficeUserController::class, 'show']);
Route::middleware('auth:api')->post('office_user', [OfficeUserController::class, 'store']);
Route::middleware('auth:api')->put('office_user/{id}', [OfficeUserController::class, 'update']);
Route::middleware('auth:api')->delete('office_user/{id}', [OfficeUserController::class, 'destroy']);
Route::middleware('auth:api')->put('office_user/delete/{id}', [OfficeUserController::class, 'delete']);

Route::middleware('auth:api')->get('users', [UserController::class, 'index']);
Route::middleware('auth:api')->get('users/{id}', [UserController::class, 'show']);
Route::post('users', [UserController::class, 'store']);
Route::middleware('auth:api')->put('users/{id}', [UserController::class, 'update']);
Route::middleware('auth:api')->delete('users/{id}', [UserController::class, 'destroy']);
Route::middleware('auth:api')->put('users/delete/{id}', [UserController::class, 'delete']);

Route::post('login', [LoginController::class, 'login']);
Route::post('pass', [TestController::class, 'pass']);
Route::post('load_document', [LoadDocumentController::class, 'loadDocument']);
