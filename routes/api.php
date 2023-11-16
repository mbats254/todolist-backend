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
    Route::get('/all/users', 'AuthApiController@all_users')->name('all.users');
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

    //Store: Add a user to the organisation
    Route::post('/organisations/add/user', 'OrganisationController@add_user')->name('organisations.add.user');

    //Store: Add a user to the organisation
    Route::post('/organisations/all/members', 'OrganisationController@all_members')->name('organisations.all.members');

     // Index: Get a list of to-do items for a specific organisation
    Route::get('/organisations/todo-items/{organisationId}', 'TodoItemController@index')->name('todo-items.index');

    // Show: Get a specific to-do item for a specific organisation
    Route::get('/organisations/todo-items/{organisationId}/{todoItemId}', 'TodoItemController@show')->name('todo-items.show');

    // Store: Create a new to-do item for a specific organisation
    Route::post('/organisations/todo-items/{organisationId}', 'TodoItemController@store')->name('todo-items.store');

    // Update: Update a specific to-do item for a specific organisation
    Route::put('/organisations/todo-items/{organisationId}/{todoItemId}', 'TodoItemController@update')->name('todo-items.update');

    // Destroy: Delete a specific to-do item for a specific organisation
    Route::delete('/organisations/{organisationId}/todo-items/{todoItemId}', 'TodoItemController@destroy')->name('todo-items.destroy');
});


