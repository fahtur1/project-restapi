<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return redirect()->route('user');
});

$router->group(
    ['prefix' => 'user'],
    function () use ($router) {
        // User Method Get
        $router->get('/', ['as' => 'user', 'uses' => 'UserController@getUsers']);
        $router->get('/{id}', 'UserController@getUserById');
        // User Method Post
        $router->post('/', 'UserController@createUser');
        // User Method put
        $router->put('/{id}', 'UserController@updateUser');
        // User Method Delete
        $router->delete('/{id}', 'UserController@deleteUser');
    }
);
