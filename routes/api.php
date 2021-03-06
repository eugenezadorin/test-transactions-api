<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Procedures\AddTransaction;
use App\Http\Procedures\GetAccountBalance;
use App\Http\Procedures\GetWeeklyRefunds;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::rpc('/v1/transactions', [
    AddTransaction::class,
    GetWeeklyRefunds::class,
])->name('rpc.transactions');

Route::rpc('/v1/accounts', [
    GetAccountBalance::class,
])->name('rpc.accounts');
