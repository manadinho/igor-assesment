<?php

use App\Http\Controllers\UrlController;
use Illuminate\Support\Facades\Route;


Route::view('/', 'welcome');

Route::post('/url-generate', [UrlController::class, 'generateUrl'])->name('url-generate');
Route::get('/{short_url}', [UrlController::class, 'redirectToOrignalurl'])->name('redirect');
