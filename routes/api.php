<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\SocialMediaController;


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
Route::apiResource('messages','\App\Http\Controllers\MessageController');
Route::apiResource('blog','\App\Http\Controllers\BlogController');
Route::apiResource('about','\App\Http\Controllers\AboutController');
Route::patch('socialmedia/{id}',[SocialMediaController::class,'update']);
Route::apiResource('contact','\App\Http\Controllers\ContactController');
Route::apiResource('destination','\App\Http\Controllers\DestinationController');
Route::apiResource('package_category','\App\Http\Controllers\PackageCategoryController');
Route::apiResource('package','\App\Http\Controllers\PackageController');