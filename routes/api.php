<?php

use Illuminate\Http\Request;
use App\Models\TopAttraction;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\CoverPhotoController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\PortraitImgController;
use App\Http\Controllers\SocialMediaController;
use App\Http\Controllers\TourEnquiryController;
use App\Http\Controllers\TopAttractionController;

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

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);


Route::apiResource('destination', DestinationController::class);
Route::apiResource('faq', FaqController::class);
Route::apiResource('top-attraction', TopAttractionController::class);


Route::apiResource('messages', '\App\Http\Controllers\MessageController');

Route::post('blog',[BlogController::class,'store']);
Route::patch('blog/{id}',[BlogController::class,'update']);
Route::delete('blog/{id}',[BlogController::class,'destroy']);

Route::apiResource('about', '\App\Http\Controllers\AboutController');
Route::get('socialmedia', [SocialMediaController::class, 'index']);
Route::patch('socialmedia/{id}', [SocialMediaController::class, 'update']);
Route::apiResource('contact', '\App\Http\Controllers\ContactController');
Route::apiResource('things-to-do', '\App\Http\Controllers\PackageCategoryController');
Route::apiResource('package', '\App\Http\Controllers\PackageController');
Route::apiResource('package-included', '\App\Http\Controllers\PackageIncludedController');
Route::apiResource('itinerary', '\App\Http\Controllers\ItineraryController');
Route::apiResource('testimonial', '\App\Http\Controllers\TestimonialController');



Route::get('destination-list', [\App\Http\Controllers\FrontendController::class, 'destination_list']);
Route::get('things-to-do-list', [\App\Http\Controllers\FrontendController::class, 'package_category_list']);

Route::get('destination-by-things-to-do/{id}', [
    \App\Http\Controllers\FrontendController::class,
    'destinationByCatagory'
]);


//cover images
Route::patch('cover-photo/{id}',[CoverPhotoController::class,'update']);
Route::delete('cover-photo/{id}',[CoverPhotoController::class,'destroy']);

//portrait images
Route::apiResource('portrait-image', '\App\Http\Controllers\PortraitImgController');
//packages in demand
Route::post('package-in-demand', [\App\Http\Controllers\FrontendController::class, 'createPackageInDemand']);
Route::patch('package-in-demand/{id}', [\App\Http\Controllers\FrontendController::class, 'updatePackageInDemand']);
Route::delete('package-in-demand/{id}', [\App\Http\Controllers\FrontendController::class, 'deletePackageInDemand']);
//top destination
Route::post('top-destination', [\App\Http\Controllers\FrontendController::class, 'createTopDestination']);
Route::patch('top-destination/{id}', [\App\Http\Controllers\FrontendController::class, 'updateTopDestination']);
Route::delete('top-destination/{id}', [\App\Http\Controllers\FrontendController::class, 'deleteTopDestination']);
//top-enquiries
Route::apiResource('tour-enquiry', '\App\Http\Controllers\TourEnquiryController');



//FRONTEND no auth
Route::group(['prefix' => 'frontend'], function () {
    Route::get('packages/{id}', [FrontendController::class,'packageByCatagory']);
    Route::get('package-in-demand', [FrontendController::class,'readPackageInDemand']);
    Route::get('cover-photo', [CoverPhotoController::class,'index']);
    Route::get('top-destination', [FrontendController::class,'readTopDestination']);
    Route::get('things-to-do-by-destination/{destination_id}', [FrontendController::class,'package_category']);
    Route::get('blog',[BlogController::class,'index']);
});

