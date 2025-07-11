<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Compte\TransactionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Users\UserController;
use App\Http\Controllers\Compte\CompteBancaireController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

////admin route
//-Route::get('/admin-dash', [AdminController::class,'index'])>middleware(['auth', 'verified'])->name('dashboard');
//

// Admin ROUTE
Route::middleware(['auth','verified'])->group(function(){

                                    // Grouped Route
    Route::prefix('admin')->name('admin.')->group(function(){
        Route::get('/', [AdminController::class,'index'])->name('dashboard');
    });

                                     //Request Route
    Route::prefix('requests')->name('requests.')->group(function(){
        Route::get('/', [AdminController::class,'requestsPending'])->name('requestsPending');

        // Get the deatail on account
        Route::get('detail/{id}', [AdminController::class,'show'])->name('detail');

        // Route for account accepted
        Route::post('validated/{id}', [AdminController::class,'validated'])->name('validated');
        Route::post('rejected/{id}', [AdminController::class,'rejected'])->name('rejected');
    });


                                  // TRANSACTION ROUTES
    Route::prefix('transaction')->name('transaction.')->group(function(){

        // view form for deposite
        Route::get('/', [TransactionController::class,'index'])->name('index');
        Route::get('deposit', [TransactionController::class,'storDeposit'])->name('deposit');

        // handle withdraw
        Route::get('withdraw', [TransactionController::class,'withdraw'])->name('withdraw');
        Route::post('storeWithdraw', [TransactionController::class, 'storeWithdraw'])->name('storeWithdraw');
    });

});

                                    //user routes
Route::middleware(['auth', 'verified'])->group(function () { // middlewar

    // index convention  better to dispplay
    Route::prefix('user')->name('user.')->group(function () { // prefix
        Route::get('/', [UserController::class, 'index'])->name('index');
    });

                                    // create account route
    Route::prefix('create_account')->name('create_account.')->group(function () {
        // store convention  better for new creation
        Route::post('/', [CompteBancaireController::class, 'store'])->name('store');
    });

});




Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
