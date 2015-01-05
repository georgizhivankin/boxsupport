<?php

/*
 * |--------------------------------------------------------------------------
 * | Application Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register all of the routes for an application.
 * | It's a breeze. Simply tell Laravel the URIs it should respond to
 * | and give it the Closure to execute when that URI is requested.
 * |
 */

/**
 * Home page controller
 *
 * The main route that displays the homepage of the application
 */
Route::resource('/', 'IndexController');

/**
 * Accounts controller
 *
 * Route that can verify a single account
 */
Route::get('verifyaccount', 'AccountController@verifyAccount');
Route::post('verifyaccount', 'AccountController@verifyAccount');

/**
 * Protected controllers
 *
 * The below routes and controllers are protected with a custom authentication filter defined in Filters.php that aims to emulate a protection that you would have if the account ID was working as an authentication mechanism, I.E. it would allow only those users who have entered a valid account ID to access all resources of the application.
 */

Route::group(array(
    'before' => 'accountAuthentication'
), function ()
{
    /**
     * Accounts controller
     * Route that shows all accounts in the system
     */
    Route::get('accounts', 'AccountController@index');
    
    /**
     * Boxes controller
     *
     * Routes that call the boxes resource and update their ratings
     */
    // Show all boxes for an account
    Route::get('account/{accountID}/boxes', 'BoxController@showBoxes');
    // Show an individual box
    Route::get('account/{accountID}/box/{id}', 'BoxController@show');
    Route::post('account/{accountID}/box/{id}', 'BoxController@show');
    // Update a box
    Route::post('account/{accountID}/box/{id}/update', 'BoxController@update');
    
    /**
     * Products controller
     *
     * Route that calls the products resource
     */
    Route::resource('products', 'ProductController');
});

/**
 * Log out route
 *
 * Route that enables accounts to be logged out
 */
Route::get('logout', 'AccountController@logout');

/**
 * Function that adds the 'active' Bootstrap class to the active menu item being accessed
 * I modified the original snippet to suit my own coding style and approach
 *
 * @author Mike Koro
 *         @Source: http://mikekoro.com/blog/laravel-4-active-class-for-navigational-menu/
 *         
 *         @param string $routeAction
 *         @param string $text
 *         @param array $params
 */
HTML::macro('cleverLink', function ($routeAction, $text, $params = array())
{
    // Check if the current route name and action match the supplied one through the navigation link and if so, set the bootstrap class to active
    if (Route::currentRouteAction() == $routeAction) {
        $active = 'class="active"';
    } else {
        $active = '';
    }
    return '<li ' . $active . '>' . link_to_action($routeAction, $text, $params) . '</li>';
});
