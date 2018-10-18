<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if(Auth::user()->hasRole('admin')) {
        return view('home');
    } else {
        return redirect('companies/'.Auth::user()->company->id);
    }
})->middleware('auth');

// Authentication Routes...
$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login');
$this->post('logout', 'Auth\LoginController@logout')->name('logout');

// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset');

/**
 * Route Group for administrator
 */
Route::group(['middleware' => ['role:admin']], function() {
    Route::resource('/users','UsersController');
    Route::get('/getUsers','UsersController@getUsers');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/rolePerms','RolesPermissionsController@index');
    Route::get('/getRoles','RolesPermissionsController@getRoles');
    Route::post('/storeRoles','RolesPermissionsController@storeRoles');
    Route::get('/getPermissions','RolesPermissionsController@getPermissions');
    Route::post('/storePermission','RolesPermissionsController@storePermission');
    Route::patch('/attachOrDetach/{role}','RolesPermissionsController@attachOrDetach');
    Route::delete('/removeRole/{role}','RolesPermissionsController@removeRole');
});

/**
 * Public API
 */
Route::get('/companiesApi','CompaniesController@getCompanies');
Route::get('/laborsApi','LaborsController@getLabors');


/**
 * Route Group for non-admin user
 */
Route::group(['middleware' => ['auth']], function() {

    // User
    Route::post('/disclaimer','UsersController@disclaimer');
    Route::get('/currentUser','UsersController@currentUser');
    Route::get('/profile/edit/{user}','UsersController@profileEdit');
    Route::patch('/profile/update/{user}','UsersController@profileUpdate');

    // Companies or Providers
    Route::get('/getCompanies','CompaniesController@getCompanies');
    Route::get('/getCompany/{company}','CompaniesController@getCompany');
    Route::resource('/companies','CompaniesController');

    // Labors or Members
    Route::get('/getLaborByCompany/{company}','LaborsController@getLaborByCompany');
    Route::get('/getLabors','LaborsController@getLabors');
    Route::patch('/changeStatus/{labor}','LaborsController@changeStatus');
    Route::patch('/updateDetails/{labor}','LaborsController@updateDetails');
    Route::resource('/labors','LaborsController');

    // Relievers or Assign
    Route::resource('/relievers','RelieversController');
    Route::get('/getRelievers','RelieversController@getRelievers');

    //Classification Route
    Route::get('/getClassifications','ClassificationsController@getClassifications');
});

Route::any('{any?}', function ($any = null) {
    if (Auth::check()) {
        return redirect('/home');
    }
});
