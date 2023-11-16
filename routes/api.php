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

Route::group(['middleware' => 'auth:api'], function () {
    // Index: Get a list of organisations
    Route::get('/organisations', 'OrganisationController@index')->name('organisations.index');

    // Show: Get a specific organisation
    Route::get('/organisations/{organisation}', 'OrganisationController@show')->name('organisations.show');

    // Store: Create a new organisation
    Route::post('/organisations', 'OrganisationController@store')->name('organisations.store');

    // Update: Update a specific organisation
    Route::put('/organisations/{organisation}', 'OrganisationController@update')->name('organisations.update');

    // Destroy: Delete a specific organisation
    Route::delete('/organisations/{organisation}', 'OrganisationController@destroy')->name('organisations.destroy');
});

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
