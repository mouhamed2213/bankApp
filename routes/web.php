<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\HandleRequest;
use App\Http\Controllers\Compte\TransactionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Users\UserController;
use App\Http\Controllers\Compte\CompteBancaireController;
use App\Http\Controllers\virtualCard\VirtualCardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

// Admin ROUTE
Route::middleware(['auth','verified'])->group(function(){

                                    // Grouped Route
    Route::prefix('admin')->name('admin.')->group(function(){
        Route::get('/', [AdminController::class,'index'])->name('dashboard');
    });

                                     //Request Route
    Route::prefix('requests')->name('requests.')->group(function(){
        Route::get('/', [HandleRequest::class,'requestsPending'])->name('requestsPending');
        // Get the deatail on account
        Route::get('detail/{id}', [HandleRequest::class,'show'])->name('detail');
        // Route for account accepted
        Route::post('/{id}', [HandleRequest::class,'demande'])->name('demande');
        Route::post('rejected/{id}', [HandleRequest::class,'rejected'])->name('rejected');
        Route::get('closure/{id}', [HandleRequest::class,'closure'])->name('closure'); // close account route
    });


                                  // TRANSACTION ROUTES
    Route::prefix('transaction')->name('transaction.')->group(function(){

        // view form for deposite
        Route::get('/', [TransactionController::class,'index'])->name('index');
        Route::POST('deposit', [TransactionController::class,'storDeposit'])->name('deposit');

        // handle withdraw
        Route::get('withdraw', [TransactionController::class,'createWithdraw'])->name('withdraw.create');
        Route::post('storeWithdraw', [TransactionController::class, 'storeWithdraw'])->name('withdraw.store');


//                                        BEST ROUTING NAMING EXAMPLE
         Route::get('transfer', [TransactionController::class,'transferCreate'])->name('transfer.create');
                                        // Store handle  the creation
        Route::post('transfer/store', [TransactionController::class,'transferStor'])->name('transfer.store');
    });


                                    // A HANDLE  USER ACCOUNT ROUTES
        Route::prefix('compte')->name('compte.')->group(function() {
            Route::get('/' , [ CompteBancaireController::class, 'index'] )->name('index');
            Route::get('/{id}' , [ CompteBancaireController::class, 'show'] )->name('show');
            Route::post('switchAccount' , [ UserController::class, 'switchAccount'] )->name('switchAccount');
        });

});

                                    //user routes
Route::middleware(['auth', 'verified'])->group(function () { // middlewar

    // index convention  better to dispplay
    Route::prefix('user')->name('user.')->group(function () { // prefix
        Route::get('/', [UserController::class, 'index'])->name('index');
    });

                                    // create account route ( TO AVOID
    Route::prefix('create_account')->name('create_account.')->group(function () {
        // store convention  better for new creation
        Route::post('/', [CompteBancaireController::class, 'store'])->name('store');
        Route::get('createAccount', [CompteBancaireController::class, 'indexCreateAccount'])->name('create.account');
        Route::post('storeAccount', [CompteBancaireController::class, 'store'])->name('store.account');

    });
});


// Virtual card
Route::prefix('virtualCard')->name('virtualCard.')->group(function () {
   Route::get('/', [VirtualCardController::class, 'index'])->name('index');
    Route::get('/download', [VirtualCardController::class, 'download'])->name('download');
    Route::get('/create', [VirtualCardController::class, 'create'])->name('create');
    Route::post('/store', [VirtualCardController::class, 'store'])->name('store');

});




Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
