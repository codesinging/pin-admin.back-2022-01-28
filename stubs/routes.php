<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

use Illuminate\Support\Facades\Route;

// 无需登录授权的路由
Route::middleware(['web', 'admin.guest:__DUMMY_NAME__'])
    ->prefix('__DUMMY_PREFIX__')
    ->group(function () {

        Route::get('/auth', [__DUMMY_NAMESPACE__\Controllers\AuthController::class, 'index']);

    });

// 需要登录授权的路由
Route::middleware(['web', 'admin.auth:__DUMMY_NAME__,__DUMMY_LABEL_____DUMMY_NAME__'])
    ->prefix('__DUMMY_PREFIX__')
    ->group(function () {

        Route::get('/', [__DUMMY_NAMESPACE__\Controllers\IndexController::class, 'index']);

    });