<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

    Route::post('/user/register','AuthApiController@register')->name('api.register');
    Route::get('/login/error','AuthApiController@api_error')->name('api.login.error');
    // Organisation Routes
    Route::post('/user/login','AuthApiController@login')->name('api.login');
    Route::middleware('auth:api')->group(function () {
    // Index: Get a list of organisations
    Route::get('/organisations', 'OrganisationController@index')->name('organisations.index');

    // Show: Get a specific organisation
    Route::get('/organisations/{id}', 'OrganisationController@show')->name('organisations.show');

    // Store: Create a new organisation
    Route::post('/organisations', 'OrganisationController@store')->name('organisations.store');

    // Update: Update a specific organisation
    Route::put('/organisations/{id}', 'OrganisationController@update')->name('organisations.update');

    // Destroy: Delete a specific organisation
    Route::delete('/organisations/{id}', 'OrganisationController@destroy')->name('organisations.destroy');
});


