<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ConnectionController;
use App\Http\Controllers\ConnectRequestController;

Route::get('/received-requests', [ConnectRequestController::class, 'receivedRequests'])->name('received-requests');
Route::post('/more-received-requests', [ConnectRequestController::class, 'getMoreReceivedRequests'])->name('user.more-received-requests');
Route::post('/more-requests', [ConnectRequestController::class, 'getMoreRequests'])->name('user.more-requests');

Route::resource('connect-request', ConnectRequestController::class);

Route::resource('connections', ConnectionController::class);

Route::get('/suggestions', [UserController::class, 'suggestions'])->name('user.suggestions');
Route::post('/more-suggestions', [UserController::class, 'getMoresuggestions'])->name('user.more-suggestions');
Route::get('/stats', [UserController::class, 'stats'])->name('user.stats');