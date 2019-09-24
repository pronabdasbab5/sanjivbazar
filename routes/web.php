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
    return view('auth.login');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {

	Route::get('/home', 'HomeController@index')->name('home');

	/** Start of Shop Router**/
	Route::get('/newshop', 'Auth\Shoplist\ShoplistController@create')->name('newshop');
	Route::post('/newshop', 'Auth\Shoplist\ShoplistController@store');
	Route::get('/shoplist', 'Auth\Shoplist\ShoplistController@index')->name('shoplist');
	Route::get('/deleteshop/{id}', 'Auth\Shoplist\ShoplistController@destroy');
	Route::get('/updateshop/{id}', 'Auth\Shoplist\ShoplistController@edit');
	Route::post('/updateshop/{id}', 'Auth\Shoplist\ShoplistController@update');
	/** End of Shop Router **/

	/** Start of Top Category **/
	Route::get('/topcategory', 'Auth\Topcategory\TopcategoryController@create')->name('topcategory');
    // Route::put('/admin/add_new_main_category', 'MaincategoryController@add_new_main_category')->name('add_new_main_category');
    // Route::get('/admin/all_main_category', 'MaincategoryController@all_main_category')->name('all_main_category');
    // Route::get('/admin/pro_cate_icon/{filename}', 'MaincategoryController@pro_cate_image')->name('pro_cate_image');
    // Route::get('/admin/change_status_main_category/{id}', 'MaincategoryController@change_status_main_category')->name('change_status_main_category');
    // Route::get('/admin/single_record_main_category/{id}', 'MaincategoryController@single_record_main_category')->name('single_record_main_category');
    // Route::put('/admin/single_record_main_category_update/{id}', 'MaincategoryController@single_record_main_category_update')->name('single_record_main_category_update');
    /** End of Top Category **/
});
