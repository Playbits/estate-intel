<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\ExternalBookController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/external-books', ExternalBookController::class);
// Route::get('/external-books', [ExternalBookController::class, 'getExternalBooksByName']);
Route::apiResource('/v1/books', BookController::class);
Route::post('/v1/books/{id}/delete', [BookController::class, 'destroy']);
