<?php

namespace App\Http\Controllers\Auth\Products;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Topcategory\Topcategory;
use App\Models\Products\Products;
use App\Models\Brands\Brands;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\Subcategory\Subcategory;
use App\Models\Products\Psss;
use App\Models\Products\Productimg;
use DateTime;
use File;
use DB;
use Response;

class ProductsController extends Controller
{
    public function create()
    {
        $top_category  = new Topcategory;
    	$top_cate_data = $top_category->all();

        return view('auth.products.new_products', ['data' => $top_cate_data]);
    }

    public function store(Request $request) {

    	$request->validate([
    		'cate_id'       => 'required',
	        'sub_cate_id'   => 'required',
	        'pro_name'      => 'required',
            'pro_img'       => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'pro_desc'      => 'required',
            'pro_add_img'   => 'required',
            'pro_add_img.*' => 'mimes:jpeg,png,jpg,gif,svg|max:2048'
	    ],
		[
	        'cate_id.required'     => 'Please ! Choose Category',
	        'sub_cate_id.required' => 'Please ! Choose Sub-Category',
	        'pro_name.required'    => 'Please ! Enter Product Name',
	        'pro_desc.required'    => 'Please ! Enter Product Description',
            'pro_img.required'     => 'Please ! Upload a valid image.',
            'pro_add_img.required' => 'Please ! Upload a valid image.',
	    ]);

    	$products     = new Products;
    	$brands       = new Brands;
    	$sub_category = new Subcategory;
        $row_check    = $products->where('pro_name', ucwords(strtolower($request->input('pro_name'))))->count();

        if ($row_check > 0)
            return redirect('/newproducts')->with('msg', 'Record already available.');
        else {

            if($request->hasFile('pro_img')) {

                $image     = $request->file('pro_img');
                $file_name = time().".jpg";

                $image_resize = Image::make($image->getRealPath());              
                $image_resize->resize(350, 200);

                if(!File::exists(public_path()."/assets"))
                    File::makeDirectory(public_path()."/assets");

                if(!File::exists(public_path()."/assets/product_img"))
                    File::makeDirectory(public_path()."/assets/product_img");

                $image_resize->save(public_path("assets/product_img/".$file_name));

                $products->pro_name       = ucwords(strtolower($request->input('pro_name')));
                $products->cate_id        = $request->input('cate_id');
                $products->sub_cate_id    = $request->input('sub_cate_id');
                $products->desc           = $request->input('pro_desc');
                $products->cover_img_path = $file_name;

                $data = [];

                if($products->save()) {

                	$i = 0;

                	foreach($request->file('pro_add_img') as $file) {

	                    $image     = $file;
	                    $file_name = time().$i.".jpg";

	                    $image_resize = Image::make($image->getRealPath());              
	                    $image_resize->resize(350, 200);

	                    if(!File::exists(public_path()."/assets"))
	                        File::makeDirectory(public_path()."/assets");

	                    if(!File::exists(public_path()."/assets/product_img"))
	                        File::makeDirectory(public_path()."/assets/product_img");

	                    $image_resize->save(public_path("assets/product_img/".$file_name));

	                    $now = new DateTime();
	                    
	                    $data['product_id'] = $products->id;
	                    $data['image_path'] = $file_name;
	                    $data['created_at'] = $now;
	                    $data['updated_at'] = $now;

	                    $i++;

	                    DB::table('product_add_image')->insert($data);
	                }

	                $brands_data = DB::table('sub_brand')->where('sub_brand.sub_cate_id', $request->input('sub_cate_id'))
                            ->join('brands', 'sub_brand.brand_id', '=', 'brands.id')
                            ->join('sub_category', 'sub_brand.sub_cate_id', '=', 'sub_category.id')
                            ->select('sub_brand.sub_cate_id', 'sub_brand.id', 'sub_brand.brand_id', 'brands.brands', 'sub_brand.status', 'sub_brand.created_at', 'sub_category.sub_cate_name')
                            ->get();

                    $size_data = DB::table('sub_size')->where('sub_size.sub_cate_id', $request->input('sub_cate_id'))
                            ->join('size', 'sub_size.size_id', '=', 'size.id')
                            ->join('sub_category', 'sub_size.sub_cate_id', '=', 'sub_category.id')
                            ->select('sub_size.sub_cate_id', 'sub_size.id', 'sub_size.size_id', 'size.size', 'sub_size.status', 'sub_size.created_at', 'sub_category.sub_cate_name')
                            ->get();

                    $shop_data = DB::table('shoplist')->get();

                    return view('auth.products.new_stock_price', ['brands' => $brands_data, 'size' => $size_data, 'shop' => $shop_data]);
                }
                else
                    return redirect('/newproducts')->with('msg', 'Something wrong while adding'); 

            } else
                return redirect('/newproducts')->with('msg', 'Please ! upload image.');  
        }
    }
}
