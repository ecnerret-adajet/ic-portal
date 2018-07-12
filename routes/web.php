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
    return view('home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/getCompanies','CompaniesController@getCompanies');
Route::get('/getCompany/{company}','CompaniesController@getCompany');
Route::resource('/companies','CompaniesController');

Route::get('/getLaborByCompany/{company}','LaborsController@getLaborByCompany');
Route::patch('/changeStatus/{labor}','LaborsController@changeStatus');
Route::resource('/labors','LaborsController');
Route::resource('/relievers','RelieversController');

Route::group(['middleware' => 'auth'], function() {

});

Route::any('{any?}', function ($any = null) {
    if (Auth::check()) {
        return redirect('/home');
    } else {
        return redirect('/');
    }
});