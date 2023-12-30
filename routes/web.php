<?php

use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

Route::view("/","pages.customer");

Route::controller(CustomerController::class)->group(function(){
    Route::post("/customers","store");
    Route::get("/customers","index");
    Route::get("/customers/{id}","show");
    Route::put("/customers/{id}","update");
    Route::delete("/customers/{id}","destroy");
});


