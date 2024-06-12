<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ReserveController;
use App\Http\Controllers\MyPageController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\RepresentativeController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CsvController;
use App\Http\Controllers\KutikomiController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',[ShopController::class,'index'])->name('index');
Route::get('/detail/{id}',[ShopController::class,'detail'])->name('detail');
Route::get('/search',[SearchController::class,'search'])->name('search');
Route::get('/sorting',[SearchController::class,'sorting'])->name('sorting');
Route::get('/thanksRegister', function () {return view('/thanksRegister');});
Route::get('/thanksReserve', function () {return view('/thanksReserve');});
Route::get('/representativeReserve/{id}',[MyPageController::class,'representativeReserve'])->name('representativeReserve');
Route::get('/kutikomiAll/{id}',[KutikomiController::class,'kutikomiAll'])->name('kutikomiAll');

Route::middleware(['auth','verified'])->group(function () {
    Route::get('/myPage',[MyPageController::class,'myPage'])->name('myPage');
    Route::get('/recommendationAdd',[MyPageController::class,'recommendationAdd'])->name('recommendationAdd');
    Route::post('/reserveAdd',[ReserveController::class,'reserveAdd'])->name('reserveAdd');
    Route::delete('/reserveDelete',[ReserveController::class,'reserveDelete'])->name('reserveDelete');
    Route::put('/reserveUpdate',[ReserveController::class,'reserveUpdate'])->name('reserveUpdate');
    Route::post('/favoriteStore',[FavoriteController::class,'favoriteStore'])->name('favoriteStore');
    Route::delete('/favoriteDelete',[FavoriteController::class,'favoriteDelete'])->name('favoriteDelete');
    Route::put('/reviewAdd',[ReviewController::class,'reviewAdd'])->name('reviewAdd');
    Route::delete('/reviewDelete',[ReviewController::class,'reviewDelete'])->name('reviewDelete');
    Route::get('/payment/create', [PaymentController::class, 'create'])->name('payment.create');
    Route::put('/payment/store', [PaymentController::class, 'store'])->name('payment.store');
    Route::get('/kutikomi/{id}',[KutikomiController::class,'kutikomiIndex'])->name('kutikomiIndex');
    Route::post('/kutikomiCreate',[KutikomiController::class,'kutikomiCreate'])->name('kutikomiCreate');
    Route::post('/kutikomiUpdate',[KutikomiController::class,'kutikomiUpdate'])->name('kutikomiUpdate');
    Route::delete('/kutikomiDelete',[KutikomiController::class,'kutikomiDelete'])->name('kutikomiDelete');
});

Route::group(['middleware' => ['auth', 'can:admin_only']], function () {
    Route::get('/accountIndex', [AccountController::class,'accountIndex'])->name('accountIndex');
    Route::get('/accountSearch', [AccountController::class,'accountSearch'])->name('accountSearch');
    Route::delete('/accountDelete', [AccountController::class,'accountDelete'])->name('accountDelete');
    Route::post('/representativeAdd', [RepresentativeController::class,'representativeAdd'])->name('representativeAdd');
    Route::delete('/representativeDelete', [RepresentativeController::class,'representativeDelete'])->name('representativeDelete');
    Route::get('/representativeSearch', [RepresentativeController::class,'representativeSearch'])->name('representativeSearch');
    Route::post('csv/upload',  [CsvController::class,'upload'])->name('upload');
});

Route::group(['middleware' => ['auth', 'can:manager_admin']], function () {
    Route::get('/managementIndex', [ManagementController::class,'managementIndex'])->name('managementIndex');
    Route::get('/shopUpdateIndex', [ManagementController::class,'shopUpdateIndex'])->name('shopUpdateIndex');
    Route::get('/shopReserve', [ManagementController::class,'shopReserve'])->name('shopReserve');
    Route::post('/shopCreate', [ManagementController::class,'shopCreate'])->name('shopCreate');
    Route::put('/shopUpdate', [ManagementController::class,'shopUpdate'])->name('shopUpdate');
    Route::get('/informMail', [ManagementController::class,'informMail'])->name('informMail');
});

require __DIR__.'/auth.php';
