<?php

namespace App\Http\Controllers\Brands;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\Brands\Brands;
use App\model\Products\Products;
use App\model\Subcategory\Subcategory;
use App\model\Subbrands\Subbrands;
use DB;

class BrandsController extends Controller
{
    public function new_brands () {

    	$brands = new Brands;

    	$brands_data = $brands->all();

    	return view('admin.brands.new_brands', ['data' => $brands_data]);
    }

    public function add_new_brands (Request $request) {

    	$request->validate([
	        'brands' => 'required'
	    ],
		[
	        'brands.required' => 'The Brands is required'
	    ]);

    	$brands = new Brands;

        $row = $brands->where('brands', $request->input('brands'))->count();

        if ($row > 0) {
            
            return redirect()->route('new_brands')->with('msg', 'Record already available.');
        }
        else {

            $brands->brands = ucwords($request->input('brands'));
            $brands->id = $brands->count() + 1;

            if($brands->save()) 
                return redirect()->route('new_brands')->with('msg', 'Brands has been added successfully');
            else
                return redirect()->route('new_brands')->with('msg', 'Something wrong while adding'); 
        }
    }

    public function save_brand_info (Request $request, $brand_id) {

        if ($request->has('brand_name')) {

            $brands = new Brands;
            
            $row_brands = $brands->where('brands', $request->input('brand_name'))->count();

            if ($row_brands > 1)
                print "1";
            else {

                $brands->where('id', $brand_id)->update(['brands' => ucwords(strtolower($request->input('brand_name')))]);
                print "1";
            }
        } else
            print "2";
    }

    public function mapping_brands () {

        $sub_category = new Subcategory;
        $sub_category_data = $sub_category->all();

        $brands = new Brands;
        $brands_data = $brands->all();

        $sub_brands_data = DB::table('sub_brand')->join('brands', 'sub_brand.brand_id', '=', 'brands.id')->join('sub_category', 'sub_brand.sub_cate_id', '=', 'sub_category.id')->select('sub_brand.sub_cate_id', 'sub_brand.id', 'sub_brand.brand_id', 'brands.brands', 'sub_brand.status', 'sub_brand.created_at', 'sub_category.sub_cate_name')->get();

        return view('admin.brands.mapping_brands', ['brands' => $brands_data, 'sub_category' => $sub_category_data, 'sub_brands_data' => $sub_brands_data]);
    }

    public function add_new_mapping_brands (Request $request) {

        $request->validate([
            'sub_cate_id' => 'bail|required',
            'brand_id' => 'required'
        ],
        [
            'sub_cate_id.required' => 'The Sub-Category is required',
            'brand_id.required' => 'The brands is required'
        ]);

        $subbrands = new Subbrands;

        $row = $subbrands->where('sub_cate_id', $request->input('sub_cate_id'))->where('brand_id', $request->input('brand_id'))->count();

        if ($row > 0) {
            
            return redirect()->route('mapping_brands')->with('msg', 'Record already available.');
        }
        else {

            $subbrands->brand_id = $request->input('brand_id');
            $subbrands->sub_cate_id = $request->input('sub_cate_id');
            $subbrands->id = $subbrands->count() + 1;

            if($subbrands->save()) 
                return redirect()->route('mapping_brands')->with('msg', 'Mapping has been added successfully');
            else
                return redirect()->route('mapping_brands')->with('msg', 'Something wrong while mapping'); 
        }
    }

    public function change_status_mapping_brands($id) {

        $subbrands = new Subbrands;
        $subbrands = $subbrands->find($id);

        $products = new Products;

        if($subbrands->status == "0") {

            $subbrands->update(['status' => "1"]);
            $products->where('sub_cate_id', $subbrands->sub_cate_id)->where('brand_id', $subbrands->brand_id)->update(['status' => "1"]);
        }
        else {

            $subbrands->update(['status' => "0"]);
            $products->where('sub_cate_id', $subbrands->sub_cate_id)->where('brand_id', $subbrands->brand_id)->update(['status' => "0"]);
        }

        $sub_category = new Subcategory;
        $sub_category_data = $sub_category->all();

        $brands = new Brands;
        $brands_data = $brands->all();

        $sub_brands_data = DB::table('sub_brand')->join('brands', 'sub_brand.brand_id', '=', 'brands.id')->join('sub_category', 'sub_brand.sub_cate_id', '=', 'sub_category.id')->select('sub_brand.sub_cate_id', 'sub_brand.id', 'sub_brand.brand_id', 'brands.brands', 'sub_brand.status', 'sub_brand.created_at', 'sub_category.sub_cate_name')->get();

        return view('admin.brands.mapping_brands', ['brands' => $brands_data, 'sub_category' => $sub_category_data, 'sub_brands_data' => $sub_brands_data]);
    }
}
