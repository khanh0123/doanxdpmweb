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

$router->group(['prefix' => 'v1','middleware' => 'cors' ], function() use($router) {

    $router->get('/menu' , ['as' => "Api.MenuController.index", 'uses' => 'Api\MenuController@index']);
    $router->get('/posts' , ['as' => "Api.PostsController.index", 'uses' => 'Api\PostsController@index']);
    $router->get('/posts/{id}' , ['as' => "Api.PostsController.detail", 'uses' => 'Api\PostsController@detail']);

}); 