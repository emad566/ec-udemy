<?php

use App\Http\Controllers;
use App\Http\Controllers\AdminController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Auth;
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
    ], function () {;

        // For Documentation Visit Link:
        // https://laracasts.com/discuss/channels/laravel/localize-app-with-jetstream
        include('routesFrtifyJetstream.php');







        //================ Guest =================//
        Route::get('/', function () {
            return view('welcome');
        });
        //================ Guest =================//

        //================ Email Verify =================//
        Route::get('/email/verify', function () {
            return view('auth.verify-email');
        })->middleware('auth')->name('verification.notice');
        //================ /Email Verify =================//

        //================ AdminGuard =================//
            //================ Login AdminGuard =================//
            Route::group([
                    'prefix'=>'admin',
                    'middleware' => ['admin:admin'],
                    // 'namespace'=>'App\Http\Controllers',
                ],
                function () {
                    Route::get('/login', 'AdminController@loginForm')->name('admin.loginForm');
                    Route::post('/login', 'AdminController@store')->name('admin.login');
                }
            );

            //================ /Login AdminGuard =================//

            //================ AdminGuard Pages =================//
            Route::group(['prefix'=>'admin/dashboard', 'middleware' => ['auth:sanctum,admin', 'AdminGuard', 'verified']], function () {

                Route::get('', function () {
                    return view('dashboard.index');
                })->name('dashboard');

                Route::post('/user/logout', 'AdminController@destroy')->name('admin.logout');

            });
            //================ /AdminGuard Pages =================//
        //================ /AdminGuard =================//

    //================ webGuard Routes =================//
    Route::group(['prefix'=>'dashboard', 'middleware' => ['auth:sanctum', 'verified']], function () {
        Route::get('/', function () {
            return view('dashboard.index');
        })->name('dashboard');

        //================ Categories =================//
        Route::resource('categories', 'categoriesController');
        Route::get('categories/{category_id?}/delete', 'categoriesController@destroy')->name('categories.destroy');
        Route::get('categories/{category_id?}/p_delete', 'categoriesController@p_destroy')->name('categories.p_destroy');
        Route::post('categories/delete', 'categoriesController@delete')->name('categories.delete');
        Route::post('categories/p_delete', 'categoriesController@p_delete')->name('categories.p_delete');
        Route::get('categories/{category_id?}/restore', 'categoriesController@restore')->name('categories.restore');
        //================ /Categories =================//

        //================ Brands =================//
        Route::resource('brands', 'brandsController');
        Route::get('brands/{category_id?}/delete', 'brandsController@destroy')->name('brands.destroy');
        Route::post('brands/delete', 'brandsController@delete')->name('brands.delete');
        //================ /Brands =================//

        //================ MainUser =================//
        Route::post('/user/logout', 'MainUserController@logout')->name('mainUser.logout');
        Route::get('/user/profile', 'MainUserController@profile')->name('mainUser.profile');
        Route::put('/user/profile', 'MainUserController@update')->name('mainUser.update');
        Route::get('/user/changePass', 'MainUserController@changePass')->name('mainUser.changePass');
        Route::put('/user/updatePass', 'MainUserController@updatePass')->name('mainUser.updatePass');
        //================ /MainUser =================//

        //================ coupons =================//
        Route::resource('coupons', 'couponsController');
        Route::get('coupons/{coupon_id?}/delete', 'couponsController@destroy')->name('coupons.destroy');
        Route::post('coupons/delete', 'couponsController@delete')->name('coupons.delete');
        Route::get('couponsUpdateIsActive/{coupon}', 'couponsController@updateIsActive')->name('coupons.updateIsActive');
        //================ /coupons =================//

        //================ newsletters =================//
        Route::resource('newsletters', 'newslettersController');
        Route::get('newsletters/{newsletter_id?}/delete', 'newslettersController@destroy')->name('newsletters.destroy');
        Route::post('newsletters/delete', 'newslettersController@delete')->name('newsletters.delete');
        Route::get('newslettersUpdateIsActive/{newsletter}', 'newslettersController@updateIsActive')->name('newsletters.updateIsActive');
        //================ /newsletters =================//



    });
    //================ /webGuard Routes =================//

    //================ Fornt Site Routes =================//
    Route::get('/',  'HomeController@home')->name('site.home');
    Route::post('/subscribe',  'newslettersController@subscribe')->name('newsletters.subscribe');
    //================ /Fornt Site Routes =================//

});
