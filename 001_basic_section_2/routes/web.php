<?php
use App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

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
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'namespace'=>'App\Http\Controllers',
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function () {

    Route::get('/', function () {
        return view('welcome');
    });

    Route::group(['prefix'=>'dashboard', 'middleware' => ['auth:sanctum', 'verified']], function () {
        Route::get('/', function () {
            // $users = User::all();
            $users = DB::table('users')->get();
            return view('dashboard', compact(['users']));
        })->name('dashboard');

        Route::resource('categories', 'categoriesController');
        Route::get('categories/{category_id?}/delete', 'categoriesController@destroy')->name('categories.destroy');
        Route::get('categories/{category_id?}/p_delete', 'categoriesController@p_destroy')->name('categories.p_destroy');
        Route::post('categories/delete', 'categoriesController@delete')->name('categories.delete');
        Route::post('categories/p_delete', 'categoriesController@p_delete')->name('categories.p_delete');
        Route::get('categories/{category_id?}/restore', 'categoriesController@restore')->name('categories.restore');

        Route::resource('brands', 'brandsController');
        Route::get('brands/{category_id?}/delete', 'brandsController@destroy')->name('brands.destroy');
        Route::post('brands/delete', 'brandsController@delete')->name('brands.delete');

    });



});
