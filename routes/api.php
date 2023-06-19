<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\CoverPhotoController;
use App\Http\Controllers\PortraitImgController;
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
Route::get('socialmedia',[SocialMediaController::class,'index']);
Route::patch('socialmedia/{id}',[SocialMediaController::class,'update']);
Route::apiResource('contact','\App\Http\Controllers\ContactController');
Route::apiResource('destination','\App\Http\Controllers\DestinationController');
Route::apiResource('things-to-do','\App\Http\Controllers\PackageCategoryController');
Route::apiResource('package','\App\Http\Controllers\PackageController');
Route::apiResource('package-included','\App\Http\Controllers\PackageIncludedController');
Route::apiResource('itinerary','\App\Http\Controllers\ItineraryController');
Route::apiResource('testimonial','\App\Http\Controllers\TestimonialController');

Route::get('destination-list',[\App\Http\Controllers\FrontendController::class,'destination_list']);
Route::get('things-to-do-list',[\App\Http\Controllers\FrontendController::class,'package_category_list']);
Route::get('things-to-do-by-destination/{destination_id}',[\App\Http\Controllers\FrontendController::class,
'package_category']);
Route::get('destination-by-things-to-do/{id}',[\App\Http\Controllers\FrontendController::class,
'destinationByCatagory']);


//cover images
Route::apiResource('cover-photo','\App\Http\Controllers\CoverPhotoController');
//portrait images
Route::apiResource('portrait-image','\App\Http\Controllers\PortraitImgController');
//packages in demand
Route::post('package-in-demand',[\App\Http\Controllers\FrontendController::class,'createPackageInDemand']);
Route::get('package-in-demand',[\App\Http\Controllers\FrontendController::class,'readPackageInDemand']);
Route::patch('package-in-demand/{id}',[\App\Http\Controllers\FrontendController::class,'updatePackageInDemand']);
Route::delete('package-in-demand/{id}',[\App\Http\Controllers\FrontendController::class,'deletePackageInDemand']);
//top destination
Route::post('top-destination',[\App\Http\Controllers\FrontendController::class,'createTopDestination']);
Route::get('top-destination',[\App\Http\Controllers\FrontendController::class,'readTopDestination']);
Route::patch('top-destination/{id}',[\App\Http\Controllers\FrontendController::class,'updateTopDestination']);
Route::delete('top-destination/{id}',[\App\Http\Controllers\FrontendController::class,'deleteTopDestination']);



//FRONTEND no auth
Route::group(['prefix' => 'frontend'], function () {
    Route::get('packages/{id}', [\App\Http\Controllers\FrontendController::class, 'packageByCatagory']);
});
