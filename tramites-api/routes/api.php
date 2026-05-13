<?php

use App\Http\Controllers\InstitucionController;
use App\Http\Controllers\TramiteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('instituciones', InstitucionController::class);

Route::apiResource('tramites', TramiteController::class);
