<?php

namespace App\Http\Controllers\Subcategory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\Maincategory\Maincategory;
use App\model\Products\Products;
use App\model\Subcategory\Subcategory;
use Intervention\Image\ImageManagerStatic as Image;
use File;
use Response;

class SubcategoryController extends Controller
{
    public function new_sub_category() {

    	$main_category = new Maincategory;

    	$main_cate_data = $main_category->all();

    	return view('admin.sub_category.new_sub_category', ['data' => $main_cate_data]);
    }

    public function add_new_sub_category (Request $request) {

    	$request->validate([
    		'cate_id' => 'required|numeric',
	        'sub_cate_name' => 'required',
            'sub_icon' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
	    ],
		[
	        'cate_id.required' => 'Please ! Choose category',
	        'sub_cate_name.required' => 'The sub-category is required',
            'sub_icon.required' => 'Please ! Upload a valid image.'
	    ]);

    	$sub_category = new Subcategory;

        $row = $sub_category->where('sub_cate_name', $request->input('sub_cate_name'))->count();

        if ($row > 0) {
            
            return redirect()->route('new_sub_category')->with('msg', 'Record already available.');
        }
        else {

            if($request->hasFile('sub_icon')) {

                $image        = $request->file('sub_icon');
                $file_name    = time().".jpg";

                $image_resize = Image::make($image->getRealPath());              
                $image_resize->resize(350, 200);

                if(!File::exists(public_path()."/assets"))
                    File::makeDirectory(public_path()."/assets");

                if(!File::exists(public_path()."/assets/sub_cate_icon"))
                    File::makeDirectory(public_path()."/assets/sub_cate_icon");

                $image_resize->save(public_path("assets/sub_cate_icon/".$file_name));

                $sub_category->pro_cate_id = $request->input('cate_id');

                $sub_category->sub_cate_name = ucwords($request->input('sub_cate_name'));

                $sub_category->img_path = $file_name;

                $sub_category->id = $sub_category->count() + 1;

                if($sub_category->save()) {

                    return redirect()->route('new_sub_category')->with('msg', 'Sub-Category has been added successfully');
                }
                else
                    return redirect()->route('new_sub_category')->with('msg', 'Something wrong while adding'); 

            } else
                return redirect()->route('new_sub_category')->with('msg', 'Please ! upload image.');  
        }
    }

    public function all_sub_category() {

        $main_category = new Maincategory;
        $sub_category = new Subcategory;

        $sub_category_data = $sub_category->with('main_category')->get();

        $data = null;

        foreach ($sub_category_data as $key => $value) {

            $url = route('sub_cate_image', ['filename' => $value['img_path']]);
            
            $data [] = [
                "subCateId" => $value['id'],
                "subCateName" => $value['sub_cate_name'],
                "imgPath" => $url,
                "mainCateName" => $value['main_category']['cate_name'],
                "mainCateStatus" => $value['main_category']['status'],
                "status" => $value['status'],
                "created_at" => $value['created_at']
            ];
        }

        return view('admin.sub_category.all_sub_category', ['data' => $data]);
    }

    public function change_status_sub_category($id) {

        $main_category = new Maincategory;
        $sub_category  = new Subcategory;
        $products      = new Products;

        $sub_category  = $sub_category->where('id', $id)->with('main_category')->get();

        $sub_category_data  = $sub_category->find($id);

        if($sub_category[0]['main_category']['status'] == "1") {

            if ($sub_category[0]['status'] == '0') {
                
                $sub_category_data->where('id', $id)->update(['status' => "1"]);
                $products->where('sub_cate_id', $id)->update(['status' => "1"]);
            } else {

                $sub_category_data->where('id', $id)->update(['status' => "0"]);
                $products->where('sub_cate_id', $id)->update(['status' => "0"]);
            }
        }

        $main_category = new Maincategory;
        $sub_category = new Subcategory;

        $sub_category_data = $sub_category->with('main_category')->get();

        $data = null;

        foreach ($sub_category_data as $key => $value) {

            $url = route('sub_cate_image', ['filename' => $value['img_path']]);
            
            $data [] = [
                "subCateId" => $value['id'],
                "subCateName" => $value['sub_cate_name'],
                "imgPath" => $url,
                "mainCateName" => $value['main_category']['cate_name'],
                "mainCateStatus" => $value['main_category']['status'],
                "status" => $value['status'],
                "created_at" => $value['created_at']
            ];
        }

        return view('admin.sub_category.all_sub_category', ['data' => $data]);
    }

    public function single_record_sub_category ($id) {

        $main_category = new Maincategory;
        $sub_category  = new Subcategory;

        $main_category = $main_category->all();
        $sub_category  = $sub_category->find($id);

        $url = route('sub_cate_image', ['filename' => $sub_category['img_path']]);
        $data = null;
            
        $data [] = [
            "mainCateId" => $sub_category['pro_cate_id'],
            "subCateId" => $sub_category['id'],
            "subCateName" => $sub_category['sub_cate_name'],
            "subCateImg" => $url
        ];

        return view('admin.sub_category.single_record_sub_category' , ['data' => $data, 'main_cate_data' => $main_category]);
    }

    public function single_record_sub_category_update (Request $request, $sub_cate_id) {

        $request->validate([
            'cate_id' => 'required',
            'sub_cate_name' => 'required',
            'icon' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ],
        [
            'cate_id.required' => 'The main-category is required',
            'sub_cate_name.required' => 'The sub-category is required',
        ]);

        $sub_category = new Subcategory;

        $row = $sub_category->where('sub_cate_name', $request->input('sub_cate_name'))->count();

        if ($row > 0) {

            if($request->hasFile('icon')) {

                $image     = $request->file('icon');
                $exlt_img  = explode('/', $request->input('old_img'));
                $file_name = end($exlt_img);

                unlink(public_path("assets/sub_cate_icon/".$file_name));

                $image_resize = Image::make($image->getRealPath());              
                $image_resize->resize(350, 200);

                if(!File::exists(public_path()."/assets"))
                    File::makeDirectory(public_path()."/assets");

                if(!File::exists(public_path()."/assets/sub_cate_icon"))
                    File::makeDirectory(public_path()."/assets/sub_cate_icon");

                $image_resize->save(public_path("assets/sub_cate_icon/".$file_name));

                $sub_category->where('id', $sub_cate_id)->update(['pro_cate_id' => $request->input('cate_id')]);

                return redirect()->route('single_record_sub_category', ['data' => $sub_cate_id])->with('msg', 'Record has been updated successfully.');
            } else{

                $sub_category->where('id', $sub_cate_id)->update(['pro_cate_id' => $request->input('cate_id')]);

                return redirect()->route('single_record_sub_category', ['data' => $sub_cate_id])->with('msg', 'Record has been updated successfully.');
            }
        }
        else {

            if($request->hasFile('icon')) {

                $image     = $request->file('icon');
                $exlt_img  = explode('/', $request->input('old_img'));
                $file_name = end($exlt_img);

                unlink(public_path("assets/sub_cate_icon/".$file_name));

                $image_resize = Image::make($image->getRealPath());              
                $image_resize->resize(350, 200);

                if(!File::exists(public_path()."/assets"))
                    File::makeDirectory(public_path()."/assets");

                if(!File::exists(public_path()."/assets/sub_cate_icon"))
                    File::makeDirectory(public_path()."/assets/sub_cate_icon");

                $image_resize->save(public_path("assets/sub_cate_icon/".$file_name));

                $sub_category->where('id', $sub_cate_id)->update(['pro_cate_id' => $request->input('cate_id'), 'sub_cate_name' => $request->input('sub_cate_name')]);

                return redirect()->route('single_record_sub_category', ['data' => $sub_cate_id])->with('msg', 'Record has been updated successfully.');
            } else{

                $sub_category->where('id', $sub_cate_id)->update(['pro_cate_id' => $request->input('cate_id'), 'sub_cate_name' => $request->input('sub_cate_name')]);

                return redirect()->route('single_record_sub_category', ['data' => $sub_cate_id])->with('msg', 'Record has been updated successfully.');
            }
        }
    }

    public function sub_cate_image ($filename) {

        $path = public_path('assets\sub_cate_icon\\'.$filename);

        if (!File::exists($path)) {

            $response = 404;
        }

        $file = File::get($path);

        $type = File::mimeType($path);

        $response = Response::make($file, 200);

        $response->header("Content-Type", $type);

        return $response;
    }
}
