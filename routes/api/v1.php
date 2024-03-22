<?php

use App\Http\Controllers\Api\V1\AuthenticationController;
use App\Http\Controllers\Api\V1\BankChannelController;
use App\Http\Controllers\Api\V1\InvitationController;
use App\Http\Controllers\Api\V1\InvitationTypeController;
use App\Http\Controllers\Api\V1\MusicController;
use App\Http\Controllers\Api\V1\PaymentChannelController;
use App\Http\Controllers\Api\V1\PermissionController;
use App\Http\Controllers\Api\V1\PermissionGroupController;
use App\Http\Controllers\Api\V1\QuotesController;
use App\Http\Controllers\Api\V1\RegionController;
use App\Http\Controllers\Api\V1\RoleController;
use App\Http\Controllers\Api\V1\ThemeController;
use App\Http\Controllers\Api\V1\WeddingDataController;
use App\Http\Controllers\Api\V1\WelcomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*--------------------------------------------------------------------------
 API Routes - Version 1
--------------------------------------------------------------------------*/

Route::prefix('v1')->name('v1.')->group(function () {
    // Welcome Routes
    Route::get('/', [WelcomeController::class, 'index'])->name('user');

    // Authentication Routes
    Route::prefix('/auth')->name('auth.')->group(function () {
        Route::post('/login', [AuthenticationController::class, 'login'])->name('login');
        Route::post('/register', [AuthenticationController::class, 'register'])->name('register')
            ->middleware('auth:sanctum', 'abilities:register');
        Route::get('/user', [AuthenticationController::class, 'user'])->name('user')
            ->middleware('auth:sanctum');
    });

    // Region Routes
    Route::prefix('/region')->name('region.')->group(function () {
        Route::get('/province', [RegionController::class, 'province'])->name('province');
        Route::get('/city', [RegionController::class, 'city'])->name('city');
        Route::get('/district', [RegionController::class, 'district'])->name('district');
        Route::get('/village', [RegionController::class, 'village'])->name('village');
    });

    // Bank Channels Routes
    Route::prefix('/bank_channel')->name('bank_channel.')->group(function () {
        Route::get('/', [BankChannelController::class, 'get'])->name('get');
        // Guarded
        Route::middleware(['auth:sanctum'])->group(function () {
            Route::post('/', [BankChannelController::class, 'create'])->name('create');
            Route::put('/', [BankChannelController::class, 'update'])->name('update');
            Route::delete('/', [BankChannelController::class, 'delete'])->name('delete');
            Route::post('/logo', [BankChannelController::class, 'updateLogo'])->name('update_logo');
            Route::delete('/logo', [BankChannelController::class, 'removeLogo'])->name('remove_logo');
            Route::patch('/activate', [BankChannelController::class, 'activate'])->name('activate');
            Route::patch('/deactivate', [BankChannelController::class, 'deactivate'])->name('deactivate');
            Route::post('/restore', [BankChannelController::class, 'restore'])->name('restore');
        });
    });

    // Invitation Type Routes
    Route::prefix('/invitation_type')->name('invitation_type.')->group(function () {
        Route::get('/', [InvitationTypeController::class, 'get'])->name('get');
        // Guarded
        Route::middleware(['auth:sanctum'])->group(function () {
            Route::post('/', [InvitationTypeController::class, 'create'])->name('create');
            Route::put('/', [InvitationTypeController::class, 'update'])->name('update');
            Route::delete('/', [InvitationTypeController::class, 'delete'])->name('delete');
            Route::patch('/activate', [InvitationTypeController::class, 'activate'])->name('activate');
            Route::patch('/deactivate', [InvitationTypeController::class, 'deactivate'])->name('deactivate');
            Route::post('/restore', [InvitationTypeController::class, 'restore'])->name('restore');
        });
    });

    // Payment Channel Routes
    Route::prefix('/payment_channel')->name('payment_channel.')->group(function () {
        Route::get('/', [PaymentChannelController::class, 'get'])->name('get');
        // Guarded
        Route::middleware(['auth:sanctum'])->group(function () {
            Route::post('/', [PaymentChannelController::class, 'create'])->name('create');
            Route::put('/', [PaymentChannelController::class, 'update'])->name('update');
            Route::delete('/', [PaymentChannelController::class, 'delete'])->name('delete');
            Route::patch('/activate', [PaymentChannelController::class, 'activate'])->name('activate');
            Route::patch('/deactivate', [PaymentChannelController::class, 'deactivate'])->name('deactivate');
            Route::post('/restore', [PaymentChannelController::class, 'restore'])->name('restore');
        });
    });

    // Permission Routes
    Route::prefix('/permission_group')->name('permission_group.')->middleware('auth:sanctum')->group(function () {
        Route::get('/', [PermissionGroupController::class, 'get'])->name('get');
        Route::post('/', [PermissionGroupController::class, 'create'])->name('create');
        Route::put('/', [PermissionGroupController::class, 'update'])->name('update');
        Route::delete('/', [PermissionGroupController::class, 'delete'])->name('delete');
        Route::post('/restore', [PermissionGroupController::class, 'restore'])->name('restore');
    });

    // Permission Routes
    Route::prefix('/permission')->name('permission.')->middleware('auth:sanctum')->group(function () {
        Route::get('/', [PermissionController::class, 'get'])->name('get');
        Route::post('/', [PermissionController::class, 'create'])->name('create');
        Route::put('/', [PermissionController::class, 'update'])->name('update');
        Route::delete('/', [PermissionController::class, 'delete'])->name('delete');
        Route::post('/restore', [PermissionController::class, 'restore'])->name('restore');
    });

    // Role Routes
    Route::prefix('/role')->name('role.')->middleware('auth:sanctum')->group(function () {
        Route::get('/', [RoleController::class, 'get'])->name('get');
        Route::post('/', [RoleController::class, 'create'])->name('create');
        Route::put('/', [RoleController::class, 'update'])->name('update');
        Route::delete('/', [RoleController::class, 'delete'])->name('delete');
        Route::post('/restore', [RoleController::class, 'restore'])->name('restore');
    });

    // Theme Routes
    Route::prefix('/theme')->name('theme.')->group(function () {
        Route::get('/', [ThemeController::class, 'get'])->name('get');
        // Guarded
        Route::middleware(['auth:sanctum'])->group(function () {
            Route::post('/', [ThemeController::class, 'create'])->name('create');
            Route::put('/', [ThemeController::class, 'update'])->name('update');
            Route::delete('/', [ThemeController::class, 'delete'])->name('delete');
            Route::post('/thumbnails', [ThemeController::class, 'updateThumbnails'])->name('update_thumbnails');
            Route::delete('/thumbnails', [ThemeController::class, 'removeThumbnails'])->name('remove_thumbnails');
            Route::patch('/activate', [ThemeController::class, 'activate'])->name('activate');
            Route::patch('/deactivate', [ThemeController::class, 'deactivate'])->name('deactivate');
            Route::post('/restore', [ThemeController::class, 'restore'])->name('restore');
            Route::get('/unallocated_path', [ThemeController::class, 'unallocated_path'])->name('get_unallocated_path');
        });
    });

    // Music Routes
    Route::prefix('/music')->name('music.')->group(function () {
        Route::get('/', [MusicController::class, 'get'])->name('get');
        // Guarded
        Route::middleware(['auth:sanctum'])->group(function () {
            Route::post('/', [MusicController::class, 'create'])->name('create');
            Route::put('/', [MusicController::class, 'update'])->name('update');
            Route::delete('/', [MusicController::class, 'delete'])->name('delete');
            Route::post('/file', [MusicController::class, 'updateFile'])->name('update_file');
            Route::post('/restore', [MusicController::class, 'restore'])->name('restore');
            Route::get('/artist', [MusicController::class, 'artist'])->name('artist');
        });
    });

    // Quotes Routes
    Route::prefix('/quote')->name('quote.')->group(function () {
        Route::get('/', [QuotesController::class, 'get'])->name('get');
        // Guarded
        Route::middleware(['auth:sanctum'])->group(function () {
            Route::post('/', [QuotesController::class, 'create'])->name('create');
            Route::put('/', [QuotesController::class, 'update'])->name('update');
            Route::delete('/', [QuotesController::class, 'delete'])->name('delete');
            Route::post('/restore', [QuotesController::class, 'restore'])->name('restore');
        });
    });

    // Invitation Routes
    Route::prefix('/invitation')->name('invitation.')->group(function () {
        Route::get('/', [InvitationController::class, 'get'])->name('get');
        Route::get('/check_prefix_route', [InvitationController::class, 'check_prefix_route'])->name('check_prefix_route');
        // Guarded
        Route::middleware(['auth:sanctum'])->group(function () {
            Route::post('/', [InvitationController::class, 'create'])->name('create');
            Route::put('/', [InvitationController::class, 'update'])->name('update');
            Route::delete('/', [InvitationController::class, 'delete'])->name('delete');
            Route::post('/restore', [InvitationController::class, 'restore'])->name('restore');
        });
    });

    // Invitation Routes
    Route::prefix('/wedding_data')->name('wedding_data.')->middleware('auth:sanctum')->group(function () {
        Route::put('/couples', [WeddingDataController::class, 'couples'])->name('couples');
        Route::put('/events', [WeddingDataController::class, 'events'])->name('events');
    });
});
