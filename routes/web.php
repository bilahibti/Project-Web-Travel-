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

    // route untuk beranda backend 
    Route::prefix('backend')->name('backend.')->middleware('auth')->group(function () { 
        Route::prefix('beranda')->name('beranda.')->controller(App\Http\Controllers\BerandaController::class)->group(function () { 
            Route::get('/beranda', 'berandaBackend')->name('beranda'); 
            Route::get('/index', 'index')->name('index');
        });
     });

    // 🔐 FRONTEND AUTH
    Route::prefix('frontend')->name('frontend.')->group(function () { 
        Route::get('beranda', [BerandaController::class, 'index'])->name('beranda');
        Route::prefix('login')->name('login.')->controller(App\Http\Controllers\LoginController::class)->group(function () { 
            Route::get('', 'loginFrontend')->name('login'); 
            Route::post('/process', 'authenticateFrontend')->name('process'); 
            Route::get('/register', 'registerFrontend')->name('register'); 
            Route::post('/register', 'storeRegister')->name('register.process'); 
            Route::post('/logout', 'logoutFrontend')->name('logout'); 
        });
    });

    // route untuk halaman statis frontend
    Route::prefix('frontend')->name('frontend.')->group(function () { 
        Route::get('/about', fn() => view('frontend.v_about.about'))->name('about'); 
        Route::get('/destinasi', fn() => view('frontend.v_destinasi.destinasi'))->name('destinasi'); 
        Route::get('/tours', fn() => view('frontend.v_tours.tours'))->name('tours'); 
        Route::get('/gallery', fn() => view('frontend.v_gallery.gallery'))->name('gallery'); 
        Route::get('/blog', fn() => view('frontend.v_blog.blog'))->name('blog'); 
        Route::get('/destinationdetails', fn() => view('frontend.v_morepages.destinationdetails'))->name('destinationdetails');
    });

    // route untuk user
    Route::prefix('user')->name('user.')->middleware('auth')->controller(App\Http\Controllers\UserController::class)->group(function () { 
        Route::get('/index', 'index')->name('index'); 
        Route::get('/create', 'create')->name('create'); 
        Route::post('/store', 'store')->name('store'); 
        Route::get('/{id}/edit', 'edit')->name('edit'); 
        Route::put('/{id}', 'update')->name('update'); 
        Route::delete('/{id}', 'destroy')->name('destroy');
        Route::get('/laporan/formuser', 'formUser')->name('laporan.formuser'); 
        Route::post('/laporan/cetakuser', 'cetakUser')->name('laporan.cetakuser');
    });

    // backend route untuk destinasi
    Route::prefix('backend')->name('backend.')->middleware('auth')->group(function () {
        Route::prefix('destinasi')->name('destinasi.')->controller(App\Http\Controllers\DestinasiController::class)->group(function () { 
            Route::get('/index', 'index')->name('index'); 
            Route::get('/create', 'create')->name('create'); 
            Route::post('/store', 'store')->name('store'); 
            Route::get('/{id}/edit', 'edit')->name('edit'); 
            Route::put('/{id}', 'update')->name('update'); 
            Route::delete('/{id}', 'destroy')->name('destroy');
        });
    });

    // backend route untuk hotel
    Route::prefix('backend')->name('backend.')->middleware('auth')->group(function () {
        Route::prefix('hotel')->name('hotel.')->controller(App\Http\Controllers\HotelController::class)->group(function () { 
            Route::get('/index', 'index')->name('index'); 
            Route::get('/create', 'create')->name('create'); 
            Route::post('/store', 'store')->name('store'); 
            Route::get('/{id}/edit', 'edit')->name('edit'); 
            Route::put('/{id}', 'update')->name('update'); 
            Route::delete('/{id}', 'destroy')->name('destroy');
        });
    });

    // backend route untuk transportasi
    Route::prefix('backend')->name('backend.')->middleware('auth')->group(function () {
        Route::prefix('transportasi')->name('transportasi.')->controller(App\Http\Controllers\TransportasiController::class)->group(function () { 
            Route::get('/index', 'index')->name('index'); 
            Route::get('/create', 'create')->name('create'); 
            Route::post('/store', 'store')->name('store'); 
            Route::get('/{id}/edit', 'edit')->name('edit'); 
            Route::put('/{id}', 'update')->name('update'); 
            Route::delete('/{id}', 'destroy')->name('destroy');
        });
    });

    // backend route untuk paket
    Route::prefix('backend')->name('backend.')->middleware('auth')->group(function () {
        Route::prefix('paket')->name('paket.')->controller(App\Http\Controllers\PaketController::class)->group(function () { 
            Route::get('/index', 'index')->name('index'); 
            Route::get('/create', 'create')->name('create'); 
            Route::post('/store', 'store')->name('store'); 
            Route::get('/{id}/edit', 'edit')->name('edit'); 
            Route::put('/{id}', 'update')->name('update'); 
            Route::delete('/{id}', 'destroy')->name('destroy');
        });
    });
});

