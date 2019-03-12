<?php

use Illuminate\Http\Request;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

//////////////////////////
//
//         USER        
//
//////////////////////////

//PROTECTED USER ROUTES

Route::group(['middleware' => 'jwt.auth'], function(){
    Route::post('/user', [
        'uses' => 'UserController@me',  
    ]);
    
    Route::post('/logout', [
        'uses' =>'UserController@logout',   
    ]); 
});

//OPEN USER ROUTES
Route::post('/register', [
    'uses' => 'UserController@signup',
    'middleware' => 'cors'
]);

Route::post('/login', [
    'uses' => 'UserController@signin',
    'middleware' => 'cors'
]);



/////////////////////////
//
//       PRODUCT
//
/////////////////////////


Route::get('/product', [
    'uses' => 'ProductController@index'
]);

Route::post('/product/create', [
    'uses' => 'ProductController@create',
    'middleware' => 'jwt.auth'
]);

Route::delete('/product/delete/{id}', [
    'uses' => 'ProductController@deleteProduct',
    'middleware' => 'jwt.auth'
]);








Route::options('{any}', ['middleware' => ['cors'], function () { return response(['status' => 'success']); }])->where('any', '.*');

