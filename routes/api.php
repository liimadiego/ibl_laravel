<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/get_all_books', [BookController::class, 'index']);
Route::get('/get_filtered_book/{search}', [BookController::class, 'getFiltered']);
Route::post('/register_book', [BookController::class, 'store']);
Route::get('/edit_book/{id}', [BookController::class, 'edit']);
Route::post('/update_book/{id}', [BookController::class, 'update']);
Route::get('/delete_book/{id}', [BookController::class, 'destroy']);