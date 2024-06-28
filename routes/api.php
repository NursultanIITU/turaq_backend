<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ProfileController;
use App\Http\Controllers\Api\V1\AdvertisementsController;
use App\Http\Controllers\Api\V1\MyAdvertisementsController;
use App\Http\Controllers\Api\V1\VerificationController;

Route::prefix('v1')->middleware(['api'])->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('/send-code', [AuthController::class, 'sendCode']);
        Route::post('/verify-code', [AuthController::class, 'verifyCode']);
        Route::post('/whatsapp-send-code', [VerificationController::class, 'sendCode']);
    });

    Route::prefix('profile')->middleware('auth:api')->group(function () {
        Route::get('/', [ProfileController::class, 'getProfile']);
        Route::post('/update', [ProfileController::class, 'update']);
    });

    Route::prefix('advertisements')->group(function () {
        Route::get('/search', [AdvertisementsController::class, 'findNearby']);
        Route::get('/advertisement/{advertisement}', [AdvertisementsController::class, 'get']);
        Route::prefix('my')->middleware(['auth:api'])->group(function () {
            Route::get('/', [MyAdvertisementsController::class, 'getAll']);
            Route::get('/{advertisement}', [MyAdvertisementsController::class, 'get']);
            Route::post('/submit', [MyAdvertisementsController::class, 'create']);
            Route::post('/{advertisement}/update', [MyAdvertisementsController::class, 'update']);
            Route::post('/{advertisement}/archive', [MyAdvertisementsController::class, 'sendToArchive']);
            Route::post('/{advertisement}/unarchive', [MyAdvertisementsController::class, 'sendToUnArchive']);
            Route::delete('/{advertisement}', [MyAdvertisementsController::class, 'delete']);
        });
        Route::get('/dictionaries', [AdvertisementsController::class, 'getDictionaries']);
        Route::post('/subscription-to-filters', [AdvertisementsController::class, 'subscriptionToFilters'])->middleware(['auth:api']);
    });
});