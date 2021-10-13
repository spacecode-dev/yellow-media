<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->group(['prefix' => 'user'], function () use ($router) {
    $router->post('register',  ['uses' => 'Auth\AuthController@register']);
    $router->post('sign-in', ['uses' => 'Auth\AuthController@signIn']);
    $router->post('recover-password', ['uses' => 'Auth\ForgotPasswordController@postEmail']);
    $router->post('recover-password/{token}', ['uses' => 'Auth\ForgotPasswordController@resetEmail']);
    $router->get('companies', ['middleware' => 'auth', 'uses' => 'CompanyController@getAll']);
    $router->post('companies', ['middleware' => 'auth', 'uses' => 'CompanyController@create']);
});
