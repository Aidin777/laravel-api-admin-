<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DuelGameplayController;
use App\Http\Controllers\DuelSessionController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
// Route::get('', [Controller::class,''])->name('');

Route::post('/sendsms', [AuthController::class, 'phoneMessage']);
Route::post('/validatesms', [AuthController::class, 'phoneValidate']);
Route::post('/register', [AuthController::class,'register']);

Route::middleware(['auth:api','checkPayment'])->group(function () {

    Route::prefix('/duels')->name('duels.')->group(function () {
        Route::get('/{id}', [DuelGameplayController::class,'index'])->name('index');
        Route::get('/{id}/contestant', [DuelGameplayController::class,'contestantData'])->name('userData');
        Route::post('/answer', [DuelGameplayController::class,'makeAnswer'])->name('answer');
        Route::post('/complete', [DuelGameplayController::class,'completeDuel'])->name('completeRound');

        Route::prefix('/session')->name('session.')->group(function () {
            Route::post('/append', [DuelSessionController::class, 'append'])->name('append');
            Route::post('/return', [DuelSessionController::class, 'returnToDuel'])->name('return');
            Route::post('/leave', [DuelSessionController::class, 'queueLeave'])->name('leave');
        });
    });

    Route::prefix('/profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::post('/store', [ProfileController::class,'store'])->name('store');
        Route::post('/verifypromo', [ProfileController::class,'verifyPromo'])->name('promoCheck');
        Route::post('/logout', [AuthController::class,'logout'])->name('logout');
    });

    Route::prefix('/galaxys')->name('galaxy.')->group(function () {
        Route::get('/', [TestController::class, 'galaxy'])->name('galaxies');
        Route::get('/{theme}/lessons', [TestController::class, 'galaxyLessons'])->name('lessons');
        Route::get('/{slug}/video', [TestController::class, 'video'])->name('video');
        Route::get('/{slug}/test', [TestController::class, 'test'])->name('test');
        Route::post('/lesson/progress', [TestController::class, 'updateProgress'])->name('update_progress');
        Route::post('/lesson/presentation', [TestController::class, 'downloadPresentation'])->name('download_pres');
    });

});

Route::prefix('/payments')->name('payments.')->group(function () {
    Route::post('/premium', [PaymentController::class, 'premiumPayment'])->name('premium');
    Route::get('/premium/callback/{operation_id}', [PaymentController::class, 'premiumCallback'])->name('premium.callback');
    Route::get('/checkPromo', [PaymentController::class, 'checkPromo'])->name('checkPromo');
});
