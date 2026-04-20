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
    return redirect('/login');
}); 

Route::get('/', function () { 
    // return view('welcome'); 
    return redirect()->route('frontend.beranda'); 
}); 

Route::get('helloworld', [HelloWorldController::class, 'index']); 
Route::get('ambilfile', [HelloWorldController::class, 'ambilFile']); 
Route::resource('anggota', AnggotaController::class); 

Route::prefix('v1')->name('v1.')->group(function () { 
    Route::prefix('backend')->name('backend.')->group(function () {
        Route::prefix('login')->name('login.')->controller(App\Http\Controllers\LoginController::class)->group(function () {
            Route::get('/login', [LoginController::class, 'loginBackend'])->name('backend.login');
            Route::post('/login', [LoginController::class, 'authenticateBackend'])->name('backend.login.process');
            Route::get('/register', [LoginController::class, 'registerBackend'])->name('backend.register');
            Route::post('/register', [LoginController::class, 'storeRegister'])->name('backend.register.process');
            Route::post('/logout', [LoginController::class, 'logoutBackend'])->name('backend.logout');
        });
    });

    Route::prefix('frontend')->name('frontend.')->group(function () { 
        Route::prefix('login')->name('login.')->controller(App\Http\Controllers\LoginController::class)->group(function () { 
            Route::get('/login', [LoginController::class, 'loginFrontend'])->name('frontend.login'); 
            Route::post('/login', [LoginController::class, 'authenticateFrontend'])->name('frontend.login.process'); 
            Route::get('/register', [LoginController::class, 'registerFrontend'])->name('frontend.register'); 
            Route::post('/register', [LoginController::class, 'storeRegister'])->name('frontend.register.process'); 
            Route::post('/logout', [LoginController::class, 'logoutFrontend'])->name('frontend.logout'); 
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

Route::get('beranda', [BerandaController::class, 'index'])->name('frontend.beranda'); 

