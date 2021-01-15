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
        Route::post('categories/delete', 'categoriesController@delete')->name('categories.delete');
    });



});
