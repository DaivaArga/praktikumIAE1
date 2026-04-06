<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\MemberController;

Route::apiResource('books', BookController::class);
Route::apiResource('members', MemberController::class);
