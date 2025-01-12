<?php

use App\Http\Controllers\PetController;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::controller(PetController::class)->group(function () {
    Route::group(['prefix' => 'pets', 'as' => 'pets.'], function () {
        Route::get('/search', 'search')->name('search_pet');
        Route::post('/search', 'search')->name('search_pet');
        Route::get('/editor/{petId?}', 'editor')->name('pet_editor');
        Route::post('/editor/{petId?}', 'editor')->name('pet_editor');
        Route::get('/delete/{petId}', 'delete')->name('delete_pet');
    });
});
