<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IpManagementController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/ip-management', [IpManagementController::class, 'index']);
    Route::post('/ip-management', [IpManagementController::class, 'store']);
    Route::put('/ip-management/{id}', [IpManagementController::class, 'update']);
    Route::get('/audit-logs', [IpManagementController::class, 'getAllAuditLogs']);
    Route::get('/audit-logs/user/{userId}', [IpManagementController::class, 'getAuditLogsByUser']);
    Route::get('/audit-logs/mac-address/{macAddressId}', [IpManagementController::class, 'getAuditLogsByMacAddress']);
});

