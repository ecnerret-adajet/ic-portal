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

Auth::routes();

Route::group(['middleware' => ['auth', 'role:admin']], function() {
    Route::resource('/users','UsersController');
    Route::get('/home', 'HomeController@index')->name('home'); 
});

Route::group(['middleware' => ['auth']], function() {
    Route::get('/getCompanies','CompaniesController@getCompanies');
    Route::get('/getCompany/{company}','CompaniesController@getCompany');
    Route::resource('/companies','CompaniesController');

    Route::get('/getLaborByCompany/{company}','LaborsController@getLaborByCompany');
    Route::patch('/changeStatus/{labor}','LaborsController@changeStatus');
    Route::resource('/labors','LaborsController');
    Route::resource('/relievers','RelieversController');
    Route::get('/getRelievers','RelieversController@getRelievers');

    //Classification Route
    Route::get('/getClassifications','ClassificationsController@getClassifications');   
});

Route::any('{any?}', function ($any = null) {
    if (Auth::check()) {
        return redirect('/home');
    } else {
        return redirect('/');
    }
});