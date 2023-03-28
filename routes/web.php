<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [UserController::class,'index']);
Route::post('/user/store', [UserController::class,'store']);
Route::get('users', [UserController::class,'get_user']);
Route::get('edit-user/{id}', [UserController::class,'edit']);
Route::put('user-update/{id}', [UserController::class,'update']);
Route::get('user-delete/{id}', [UserController::class,'destroy']);
