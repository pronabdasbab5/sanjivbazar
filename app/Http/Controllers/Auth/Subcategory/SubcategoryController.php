<?php

namespace App\Http\Controllers\Auth\Subcategory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Topcategory\Topcategory;
use App\Models\Subcategory\Subcategory;
use Intervention\Image\ImageManagerStatic as Image;
use File;
use Response;

class SubcategoryController extends Controller
{
    public function create() {

    	$top_category  = new Topcategory;
    	$top_cate_data = $top_category->all();

    	return view('auth.sub_category.new_subcategory', ['data' => $top_cate_data]);
    }

    public function store (Request $request) {

    	$request->validate([
    		'cate_id'       => 'required|numeric',
	        'sub_cate_name' => 'required',
            'sub_icon'      => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
	    ],
		[
	        'cate_id.required'       => 'Please ! Choose category',
	        'sub_cate_name.required' => 'The sub-category is required',
            'sub_icon.required'      => 'Please ! Upload a valid image.'
	    ]);

    	$sub_category = new Subcategory;
        $row_check    = $sub_category->where('sub_cate_name', $request->input('sub_cate_name'))->count();

        if ($row_check > 0) 
            return redirect()->route('newsubcategory')->with('msg', 'Record already available.');
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

                $sub_category->pro_cate_id   = $request->input('cate_id');
                $sub_category->sub_cate_name = ucwords(strtolower($request->input('sub_cate_name')));
                $sub_category->img_path      = $file_name;
                $sub_category->id            = $sub_category->count() + 1;

                if($sub_category->save()) 
                    return redirect()->route('newsubcategory')->with('msg', 'Sub-Category has been added successfully');
                else
                    return redirect()->route('newsubcategory')->with('msg', 'Something wrong while adding'); 
            } else
                return redirect()->route('newsubcategory')->with('msg', 'Please ! upload image.');  
        }
    }

    public function index () {

        $top_category = new Topcategory;
        $sub_category = new Subcategory;

        $sub_category_data = $sub_category->with('top_category')->get();

        $data = null;

        foreach ($sub_category_data as $key => $value) {

            $url = route('sub_cate_image', ['filename' => $value['img_path']]);
            
            $data [] = [
                "sub_cate_id"     => $value['id'],
                "sub_cate_name"   => $value['sub_cate_name'],
                "img_path"        => $url,
                "top_cate_name"   => $value['top_category']['cate_name'],
                "top_cate_status" => $value['top_category']['status'],
                "status"          => $value['status'],
                "created_at"      => $value['created_at']
            ];
        }

        return view('auth.sub_category.subcategorylist', ['data' => $data]);
    }

    public function change_status($id) {

        $top_category = new Topcategory;
        $sub_category = new Subcategory;

        $sub_category      = $sub_category->where('id', $id)->with('top_category')->get();
        $sub_category_data = $sub_category->find($id);

        if($sub_category[0]['top_category']['status'] == "1") {

            if ($sub_category[0]['status'] == '0') {
                
                $sub_category_data->where('id', $id)->update(['status' => "1"]);
            } else {

                $sub_category_data->where('id', $id)->update(['status' => "0"]);
            }
        }

        $top_category = new Topcategory;
        $sub_category = new Subcategory;

        $sub_category_data = $sub_category->with('top_category')->get();

        $data = null;

        foreach ($sub_category_data as $key => $value) {

            $url = route('sub_cate_image', ['filename' => $value['img_path']]);
            
            $data [] = [
                "sub_cate_id"     => $value['id'],
                "sub_cate_name"   => $value['sub_cate_name'],
                "img_path"        => $url,
                "top_cate_name"   => $value['top_category']['cate_name'],
                "top_cate_status" => $value['top_category']['status'],
                "status"          => $value['status'],
                "created_at"      => $value['created_at']
            ];
        }

        return view('auth.sub_category.subcategorylist', ['data' => $data]);
    }

    public function edit ($id) {

        $top_category = new Topcategory;
        $sub_category = new Subcategory;

        $top_category = $top_category->all();
        $sub_category = $sub_category->find($id);

        $url = route('sub_cate_image', ['filename' => $sub_category['img_path']]);
        $data = null;
            
        $data [] = [
            "top_cate_id"   => $sub_category['pro_cate_id'],
            "sub_cate_id"   => $sub_category['id'],
            "sub_cate_name" => $sub_category['sub_cate_name'],
            "sub_cate_img"  => $url
        ];

        return view('auth.sub_category.edit_subcategory_details' , ['data' => $data, 'top_cate_data' => $top_category]);
    }

    public function update (Request $request, $sub_cate_id) {

        $request->validate([
            'cate_id'       => 'required',
            'sub_cate_name' => 'required',
            'icon'          => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ],
        [
            'cate_id.required'       => 'The main-category is required',
            'sub_cate_name.required' => 'The sub-category is required',
        ]);

        $sub_category = new Subcategory;
        $row_check    = $sub_category->where('sub_cate_name', $request->input('sub_cate_name'))->count();

        if ($row_check > 0) {

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

                return redirect('/updatesubcategory/'.$sub_cate_id)->with('msg', 'Record has been updated successfully.');
            } else{

                $sub_category->where('id', $sub_cate_id)->update(['pro_cate_id' => $request->input('cate_id')]);

                return redirect('/updatesubcategory/'.$sub_cate_id)->with('msg', 'Record has been updated successfully.');
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

                return redirect('/updatesubcategory/'.$sub_cate_id)->with('msg', 'Record has been updated successfully.');
            } else{

                $sub_category->where('id', $sub_cate_id)->update(['pro_cate_id' => $request->input('cate_id'), 'sub_cate_name' => $request->input('sub_cate_name')]);

                return redirect('/updatesubcategory/'.$sub_cate_id)->with('msg', 'Record has been updated successfully.');
            }
        }
    }

    public function sub_cate_image ($filename) {

        $path = public_path('assets\sub_cate_icon\\'.$filename);

        if (!File::exists($path)) {

            $response = 404;
        }

        $file = File::get($path);

        $type = File::extension($path);

        $response = Response::make($file, 200);

        $response->header("Content-Type", $type);

        return $response;
    }
}
