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

Route::post('/', 'api\SubscriberApi@index');
Route::post('/subscribe', 'api\SubscriberApi@subscribe');
Route::post('/add_post', 'api\PostApi@add');
