<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HelloWorldController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\TransportationController;
use App\Http\Controllers\TravelPackagesController;



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
            Route::get('/admin/dashboard', 'berandaBackend')->name('admin.dashboard');
            Route::get('/staff/dashboard', fn() => view('backend.v_beranda.staff'))->name('staff.dashboard');
            Route::get('/finance/dashboard', fn() => view('backend.v_beranda.finance'))->name('finance.dashboard');
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
        Route::get('/destination', fn() => view('frontend.v_destination.destination'))->name('destination'); 
        Route::get('/tours', fn() => view('frontend.v_tours.tours'))->name('tours'); 
        Route::get('/gallery', fn() => view('frontend.v_gallery.gallery'))->name('gallery'); 
        Route::get('/blog', fn() => view('frontend.v_blog.blog'))->name('blog'); 
    });

    // route untuk user
    Route::prefix('user')->name('user.')->middleware('auth')->controller(App\Http\Controllers\UserController::class)->group(function () { 
        Route::get('/index', 'index')->name('index'); 
        Route::get('/create', 'create')->name('create'); 
        Route::post('/store', 'store')->name('store'); 
        Route::get('/{id}/edit', 'edit')->name('edit'); 
        Route::put('/{id}', 'update')->name('update'); 
        Route::delete('/{id}', 'destroy')->name('destroy');
        Route::get('/report/formuser', 'formUser')->name('report.formuser'); 
        Route::post('/report/printuser', 'printUser')->name('report.printuser');
    });

    // backend route untuk destinasi
    Route::prefix('backend')->name('backend.')->middleware('auth')->group(function () {
        Route::prefix('destination')->name('destination.')->controller(App\Http\Controllers\DestinationController::class)->group(function () { 
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
        Route::prefix('transportation')->name('transportation.')->controller(App\Http\Controllers\TransportationController::class)->group(function () { 
            Route::get('/index', 'index')->name('index'); 
            Route::get('/create', 'create')->name('create'); 
            Route::post('/store', 'store')->name('store'); 
            Route::get('/{id}/edit', 'edit')->name('edit'); 
            Route::put('/{id}', 'update')->name('update'); 
            Route::delete('/{id}', 'destroy')->name('destroy');
        });
    });

    // backend route untuk travel_packages
    Route::prefix('backend')->name('backend.')->middleware('auth')->group(function () {
        Route::prefix('travel-packages')->name('travel-packages.')->controller(App\Http\Controllers\TravelPackagesController::class)->group(function () { 
            Route::get('/index', 'index')->name('index'); 
            Route::get('/create', 'create')->name('create'); 
            Route::post('/store', 'store')->name('store'); 
            Route::get('/{id}/edit', 'edit')->name('edit'); 
            Route::put('/{id}', 'update')->name('update'); 
            Route::delete('/{id}', 'destroy')->name('destroy');
        });
    });
});

