<?php

use App\Models\Destination;
use Illuminate\Http\Request;
use App\Models\TopAttraction;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\CoverPhotoController;
use App\Http\Controllers\AssociationController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PortraitImgController;
use App\Http\Controllers\SocialMediaController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\TopAttractionController;
use App\Models\Package;

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



Route::post('blog',[BlogController::class,'store']);
Route::patch('blog/{id}',[BlogController::class,'update']);
Route::delete('blog/{id}',[BlogController::class,'destroy']);

Route::apiResource('about', '\App\Http\Controllers\AboutController');
Route::get('socialmedia', [SocialMediaController::class, 'index']);
Route::patch('socialmedia/{id}', [SocialMediaController::class, 'update']);
Route::apiResource('contact', '\App\Http\Controllers\ContactController');
Route::apiResource('things-to-do', '\App\Http\Controllers\PackageCategoryController');
Route::apiResource('package', '\App\Http\Controllers\PackageController');
Route::post('/testimonial',[TestimonialController::class,'store']);
Route::patch('/testimonial/{id}',[TestimonialController::class,'update']);
Route::delete('/testimonial/{id}',[TestimonialController::class,'destroy']);

//Review Enquiry
Route::get('review',[EnquiryController::class,'indexReview']);
Route::post('review',[EnquiryController::class,'storeReview']);
Route::delete('review/{id}',[EnquiryController::class,'destroyReview']);
//Trip Enquiry
Route::get('trip-enquiry',[EnquiryController::class,'indexTrip']);
Route::post('trip-enquiry',[EnquiryController::class,'storeTrip']);
Route::delete('trip-enquiry/{id}',[EnquiryController::class,'destroyTrip']);
//Tour Enquiry
Route::get('tour-enquiry',[EnquiryController::class,'indexTour']);
Route::post('tour-enquiry',[EnquiryController::class,'storeTour']);
Route::delete('tour-enquiry/{id}',[EnquiryController::class,'destroyTour']);
//Normal Enquiry
Route::get('messages',[EnquiryController::class,'indexMessage']);
Route::post('messages',[EnquiryController::class,'storeMessage']);
Route::delete('messages/{id}',[EnquiryController::class,'destroyMessage']);

Route::get('destination-list', [\App\Http\Controllers\FrontendController::class, 'destination_list']);
Route::get('things-to-do-list', [\App\Http\Controllers\FrontendController::class, 'package_category_list']);

Route::get('destination-by-things-to-do/{id}', [
    \App\Http\Controllers\FrontendController::class,
    'destinationByCatagory'
]);
//Association
Route::post('association',[AssociationController::class,'store']);
Route::patch('association/{id}',[AssociationController::class,'update']);
Route::delete('association/{id}',[AssociationController::class,'destroy']);

//General Setting
Route::get('setting',[SettingController::class,'index']);
Route::post('setting',[SettingController::class,'store']);
Route::patch('setting/{id}',[SettingController::class,'update']);
Route::delete('setting/{id}',[SettingController::class,'destroy']);

//cover images
Route::patch('cover-photo/{id}',[DestinationController::class,'updateCover']);
Route::delete('cover-photo/{id}',[DestinationController::class,'deleteCover']);

//packages in demand
Route::post('package-in-demand', [\App\Http\Controllers\FrontendController::class, 'createPackageInDemand']);
Route::patch('package-in-demand/{id}', [\App\Http\Controllers\FrontendController::class, 'updatePackageInDemand']);
Route::delete('package-in-demand/{id}', [\App\Http\Controllers\FrontendController::class, 'deletePackageInDemand']);
//top destination
Route::post('top-destination', [\App\Http\Controllers\FrontendController::class, 'createTopDestination']);
Route::patch('top-destination/{id}', [\App\Http\Controllers\FrontendController::class, 'updateTopDestination']);
Route::delete('top-destination/{id}', [\App\Http\Controllers\FrontendController::class, 'deleteTopDestination']);

//FRONTEND no auth
Route::group(['prefix' => 'frontend'], function () {
    Route::get('packages/{id}', [FrontendController::class,'packageByCatagory']);
    Route::get('association',[AssociationController::class,'index']);
    Route::get('package-in-demand', [FrontendController::class,'readPackageInDemand']);
    Route::get('cover-photo/{destination_id}',[DestinationController::class,'indexCover']);
    Route::get('/testimonial',[TestimonialController::class,'index']);
    Route::get('top-destination', [FrontendController::class,'readTopDestination']);
    Route::get('things-to-do-by-destination/{destination_id}', [FrontendController::class,'package_category']);
    Route::get('blog',[BlogController::class,'index']);
});

