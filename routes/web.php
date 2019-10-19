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

	/** Start of Top-Category Router **/
	Route::get('/newtopcategory', 'Auth\Topcategory\TopcategoryController@create')->name('newtopcategory');
    Route::put('/newtopcategory', 'Auth\Topcategory\TopcategoryController@store');
    Route::get('/topcategorylist', 'Auth\Topcategory\TopcategoryController@index')->name('topcategorylist');
    Route::get('/pro_cate_icon/{filename}', 'Auth\Topcategory\TopcategoryController@pro_cate_image')->name('pro_cate_image');
    Route::get('/topcategory_change_status/{id}', 'Auth\Topcategory\TopcategoryController@change_status')->name('topcategory_change_status');
    Route::get('/updatetopcategory/{id}', 'Auth\Topcategory\TopcategoryController@edit');
    Route::put('/updatetopcategory/{id}', 'Auth\Topcategory\TopcategoryController@update');
    /** End of Top-Category Router **/

    /** Start of Sub-Category Router **/
	Route::get('/newsubcategory', 'Auth\Subcategory\SubcategoryController@create')->name('newsubcategory');
    Route::put('/newsubcategory', 'Auth\Subcategory\SubcategoryController@store');
    Route::get('/subcategorylist', 'Auth\Subcategory\SubcategoryController@index')->name('subcategorylist');
    Route::get('/sub_cate_icon/{filename}', 'Auth\Subcategory\SubcategoryController@sub_cate_image')->name('sub_cate_image');
    Route::get('/subcategorychange_status/{id}', 'Auth\Subcategory\SubcategoryController@change_status')->name('subcategorychange_status');
    Route::get('/updatesubcategory/{id}', 'Auth\Subcategory\SubcategoryController@edit');
    Route::put('/updatetopcategory/{id}', 'Auth\Subcategory\SubcategoryController@update');
    /** End of Sub-Category Router **/

    /** Start of Brand, Brands-Sub-Category Router **/
    Route::get('/newbrands', 'Auth\Brands\BrandsController@create')->name('newbrands');
    Route::post('/newbrands', 'Auth\Brands\BrandsController@store');
    Route::get('/updatebrands/{brand_id}', function(App\Models\Brands\Brands $brands, $brand_id) {

        $brands_data = $brands->find($brand_id);

        $value = "<p id=\"brand_id_modal\" hidden>".$brands_data['id']."</p><p>Brand Name : <input type=\"text\" style=\"padding-left: 6px; border-radius: 4px; font-weight: bold;\" id=\"brand_name_modal\" value=\"".$brands_data['brands']."\"/><font style=\"margin-left: 10px;\" id=\"brand_name_text\"></font></p><p><center><p id=\"response_msg\"></p><hr><button type=\"button\" id=\"btn_save_brand_info\" class=\"btn btn-danger\" onclick=\"save_brand_info()\">Update</button></center></p>";

        print $value;
    });
    Route::post('/updatebrands/{brand_id}', 'Auth\Brands\BrandsController@update');
    Route::get('/newmapping_brands', 'Auth\Brands\BrandsController@create_mapping_brands')->name('newmapping_brands');
    Route::post('/newmapping_brands', 'Auth\Brands\BrandsController@store_mapping_brands');
    Route::get('/mapping_brands_change_status/{id}', 'Auth\Brands\BrandsController@change_status')->name('mapping_brands_change_status');
    /** End of Brand, Brands-Sub-Category Router **/

    /** Start of Brand, Brands-Sub-Category Router **/
    Route::get('/newsize', 'Auth\Size\SizeController@create')->name('newsize');
    Route::post('/newsize', 'Auth\Size\SizeController@store');
    Route::get('/updatesize/{size_id}', function(App\Models\Size\Size $size, $size_id) {

        $size_data = $size->find($size_id);

        $value = "<p id=\"size_id_modal\" hidden>".$size_data['id']."</p><p>Size Name : <input type=\"text\" style=\"padding-left: 6px; border-radius: 4px; font-weight: bold;\" id=\"size_name_modal\" value=\"".$size_data['size']."\"/><font style=\"margin-left: 10px;\" id=\"size_name_text\"></font></p><p><center><p id=\"response_msg\"></p><hr><button type=\"button\" id=\"btn_save_size_info\" class=\"btn btn-danger\" onclick=\"save_size_info()\">Update</button></center></p>";

        print $value;
    });
    Route::post('/updatesize/{size_id}', 'Auth\Size\SizeController@update');
    Route::get('/newmapping_size', 'Auth\Size\SizeController@create_mapping_size')->name('newmapping_size');
    Route::post('/newmapping_size', 'Auth\Size\SizeController@store_mapping_size');
    Route::get('/mapping_size_change_status/{id}', 'Auth\Size\SizeController@change_status')->name('mapping_size_change_status');
    /** End of Brand, Brands-Sub-Category Router **/

    /** Start of Product, Stock and Price **/
    Route::get('/newproducts', 'Auth\Products\ProductsController@create')->name('newproducts');
    Route::put('/newproducts', 'Auth\Products\ProductsController@store');
        // Route::get('/admin/all_products', 'ProductsController@all_products')->name('all_products');
        // Route::post('/admin/all_products_data', 'ProductsController@all_products_data')->name('all_products_data');
        // Route::get('/admin/product_status_change/{product_id}', 'ProductsController@product_status_change')->name('product_status_change');
        // Route::post('/admin/save_product_stock/{product_id}', 'ProductsController@save_product_stock')->name('save_product_stock');
        // Route::get('/admin/product_edit/{product_id}', 'ProductsController@product_edit')->name('product_edit');
        // Route::post('/admin/save_product/{product_id}', 'ProductsController@save_product')->name('save_product');
        // Route::get('/admin/all_products_images/{productId}', 'ProductsController@all_products_images')->name('all_products_images');
        // Route::get('/admin/product_images/{filename}', 'ProductsController@product_images')->name('product_images');
        // Route::put('/admin/upload_product_images/{fileName}/{productId}', 'ProductsController@upload_product_images')->name('upload_product_images');
        // Route::get('/admin/add_popular_product/{productId}', 'ProductsController@add_popular_product')->name('add_popular_product');
        // Route::get('/admin/all_popular_products', 'ProductsController@all_popular_products')->name('all_popular_products');
        // Route::get('/admin/delete_popular_product/{productId}', 'ProductsController@delete_popular_product')->name('delete_popular_product');
    Route::get('/ajax_retrive_subcategory/{cate_id}', function(App\Models\Subcategory\Subcategory $subcategory, $cate_id) {

        $sub_category_1 = $subcategory->where('pro_cate_id', $cate_id)->get();
        $sub_category_2 = "<option disabled selected>Choose Sub-Category</option>";

        foreach ($sub_category_1 as $key => $value) 
            $sub_category_2 = $sub_category_2."<option value=\"".$value['id']."\">".$value['sub_cate_name']."</option>";
        
        print $sub_category_2;

    });
    /** End of Product, Stock and Price **/
});
