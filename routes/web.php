<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HelloWorldController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DestinasiController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\TransportasiController;
use App\Http\Controllers\PaketController;



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

Route::get('/', function () { 
    return redirect()->route('v1.frontend.beranda'); 
});

Route::get('helloworld', [HelloWorldController::class, 'index']); 
Route::get('ambilfile', [HelloWorldController::class, 'ambilFile']); 
Route::resource('anggota', AnggotaController::class); 

Route::prefix('v1')->name('v1.')->group(function () { 
    // 🔐 BACKEND AUTH
    Route::prefix('backend')->name('backend.')->group(function () {
        Route::prefix('login')->name('login.')->controller(App\Http\Controllers\LoginController::class)->group(function () {
            Route::get('',  'loginBackend')->name('login');
            Route::post('',  'authenticateBackend')->name('process');
            Route::get('/register', 'registerBackend')->name('register');
            Route::post('/register', 'storeRegister')->name('register.process');
            Route::post('/logout', 'logoutBackend')->name('logout');
        });
    });

    //
    Route::prefix('backend')->name('backend.')->middleware('auth')->group(function () { 
        Route::prefix('beranda')->name('beranda.')->controller(App\Http\Controllers\BerandaController::class)->group(function () { 
            Route::get('', 'berandaBackend')->name('beranda'); 
            Route::get('', 'index')->name('index');
        });
     });

    Route::prefix('frontend')->name('frontend.')->group(function () { 
        Route::get('beranda', [BerandaController::class, 'index'])->name('beranda');
        Route::prefix('login')->name('login.')->controller(App\Http\Controllers\LoginController::class)->group(function () { 
            Route::get('', 'loginFrontend')->name('login'); 
            Route::post('', 'authenticateFrontend')->name('login.process'); 
            Route::get('/register', 'registerFrontend')->name('register'); 
            Route::post('/register', 'storeRegister')->name('register.process'); 
            Route::post('/logout', 'logoutFrontend')->name('logout'); 
        });
    });


});


Route::get('backend/beranda', [BerandaController::class, 'berandaBackend'])->name('backend.beranda')->middleware('auth'); 
Route::get('/admin/dashboard', [BerandaController::class, 'berandaBackend'])->name('backend.admin.dashboard'    );
Route::get('/staff/dashboard', fn() => view('backend.v_beranda.staff'))->name('backend.staff.dashboard');
Route::get('/finance/dashboard', fn() => view('backend.v_beranda.finance'))->name('backend.finance.dashboard');

// Route::resource('backend/user', UserController::class)->middleware('auth'); 
Route::resource('backend/user', UserController::class, ['as' => 'backend'])->middleware('auth'); 
Route::resource('backend/destinasi', DestinasiController::class, ['as' => 'backend'])->middleware('auth'); 
Route::resource('backend/hotel', HotelController::class, ['as' => 'backend'])->middleware('auth');
Route::resource('backend/transportasi', TransportasiController::class, ['as' => 'backend'])->middleware('auth');
Route::resource('backend/paket', PaketController::class, ['as' => 'backend'])->middleware('auth');  

Route::view('/about', 'frontend.v_about.about')
    ->name('frontend.about');
Route::view('/destinasi', 'frontend.v_destinasi.destinasi')
    ->name('frontend.destinasi');
Route::view('/tours', 'frontend.v_tours.tours')
    ->name('frontend.tours');
Route::view('/gallery', 'frontend.v_gallery.gallery')
    ->name('frontend.gallery');
Route::view('/blog', 'frontend.v_blog.blog')
    ->name('frontend.blog');

Route::get('backend/laporan/formuser', [UserController::class, 'formUser'])->name('backend.laporan.formuser')->middleware('auth'); 
Route::post('backend/laporan/cetakuser', [UserController::class, 'cetakUser'])->name('backend.laporan.cetakuser')->middleware('auth'); 



