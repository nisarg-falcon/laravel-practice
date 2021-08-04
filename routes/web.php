<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TestController;
use App\Models\Image;
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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/image',function(){ return view('image-upload')->with('images',Image::all()); })->name('image.upload.view');
Route::post('/image/upload',[TestController::class,'image_upload'])->name('image.upload.submit');
Route::post('/image/multiple/upload',[TestController::class,'multi_image_upload'])->name('multi.image.upload.submit');
Route::get('/image/download/{image:image_name}',[TestController::class, 'downloadImage'])->name('image.download');
