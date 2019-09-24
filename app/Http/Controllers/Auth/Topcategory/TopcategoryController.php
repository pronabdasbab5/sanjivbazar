<?php

namespace App\Http\Controllers\Auth\Topcategory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Models\Topcategory\Topcategory;
use File;
use Response;

class TopcategoryController extends Controller
{
    /**
     * Show the form for creating a new shop.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('auth.top_category.new_shop');
    }

    public function add_new_main_category (Request $request) {

    	$request->validate([
	        'cate_name' => 'required',
            'icon' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
	    ],
		[
	        'cate_name.required' => 'The main category is required',
            'icon.required' => 'Please ! Upload valid image.'
	    ]);

    	$main_category = new Maincategory;

        $row = $main_category->where('cate_name', $request->input('cate_name'))->count();

        if ($row > 0) {
            
            return redirect()->route('new_main_category')->with('msg', 'Record already available.');
        }
        else {

            if($request->hasFile('icon')) {

                $image        = $request->file('icon');
                $file_name    = time().".jpg";

                $image_resize = Image::make($image->getRealPath());              
                $image_resize->resize(350, 200);

                if(!File::exists(public_path()."/assets"))
                    File::makeDirectory(public_path()."/assets");

                if(!File::exists(public_path()."/assets/pro_cate_icon"))
                    File::makeDirectory(public_path()."/assets/pro_cate_icon");

                $image_resize->save(public_path("assets/pro_cate_icon/".$file_name));

                $main_category->cate_name = ucwords($request->input('cate_name'));

                $main_category->img_path = $file_name;

                $main_category->id = $main_category->count() + 1;

                if($main_category->save()) {

                    return redirect()->route('new_main_category')->with('msg', 'Category has been added successfully');
                }
                else
                    return redirect()->route('new_main_category')->with('msg', 'Something wrong while adding'); 

            } else
                return redirect()->route('new_main_category')->with('msg', 'Please ! upload image.');  
        }
    }

    public function all_main_category () {

        $main_category = new Maincategory;

        $main_category_data = $main_category->all();

        $data = null;

        foreach ($main_category_data as $key => $value) {

            $url = route('pro_cate_image', ['filename' => $value['img_path']]);
            
            $data [] = [
                "id" => $value['id'],
                "cate_name" => $value['cate_name'],
                "img_path" => $url,
                "status" => $value['status'],
                "created_at" => $value['created_at']
            ];
        }

        return view('admin.main_category.all_main_category', ['data' => $data]);
    }

    public function change_status_main_category($id) {

        $main_category = new Maincategory;
        $sub_category  = new Subcategory;
        $products      = new Products;

        $main_category = $main_category->find($id);

        if($main_category->status == "0") {

            $main_category->update(['status' => "1"]);
            $sub_category->where('pro_cate_id', $id)->update(['status' => "1"]);
            $products->where('cate_id', $id)->update(['status' => "1"]);
        }
        else {

            $main_category->update(['status' => "0"]);
            $sub_category->where('pro_cate_id', $id)->update(['status' => "0"]);
            $products->where('cate_id', $id)->update(['status' => "0"]);
        }

        $main_category_data = $main_category->all();

        $data = null;

        foreach ($main_category_data as $key => $value) {

            $url = route('pro_cate_image', ['filename' => $value['img_path']]);
            
            $data [] = [
                "id" => $value['id'],
                "cate_name" => $value['cate_name'],
                "img_path" => $url,
                "status" => $value['status'],
                "created_at" => $value['created_at']
            ];
        }

        return view('admin.main_category.all_main_category', ['data' => $data]);
    }

    public function single_record_main_category ($id) {

        $main_category = new Maincategory;

        $main_category = $main_category->find($id);

        $url = route('pro_cate_image', ['filename' => $main_category->img_path]);

        $data = null;
            
        $data [] = [
            "id" => $main_category->id,
            "cate_name" => $main_category->cate_name,
            "img_path" => $url
        ];

        return view('admin.main_category.single_record_main_category' , ['data' => $data]);
    }

    public function single_record_main_category_update (Request $request, $cate_id) {

        $request->validate([
            'cate_name' => 'required',
            'icon' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ],
        [
            'cate_name.required' => 'The main category is required',
        ]);

        $main_category = new Maincategory;

        $row = $main_category->where('cate_name', $request->input('cate_name'))->count();

        if ($row > 0) {

            if($request->hasFile('icon')) {

                $image     = $request->file('icon');
                $exlt_img  = explode('/', $request->input('old_img'));
                $file_name = end($exlt_img);

                unlink(public_path("assets/pro_cate_icon/".$file_name));

                $image_resize = Image::make($image->getRealPath());              
                $image_resize->resize(350, 200);

                if(!File::exists(public_path()."/assets"))
                    File::makeDirectory(public_path()."/assets");

                if(!File::exists(public_path()."/assets/pro_cate_icon"))
                    File::makeDirectory(public_path()."/assets/pro_cate_icon");

                $image_resize->save(public_path("assets/pro_cate_icon/".$file_name));

                return redirect()->route('single_record_main_category', ['data' => $cate_id])->with('msg', 'Record has been updated successfully.');
            } else
                return redirect()->route('single_record_main_category', ['data' => $cate_id])->with('msg', 'Record has been updated successfully.');
        }
        else {

            if($request->hasFile('icon')) {

                $image     = $request->file('icon');
                $exlt_img  = explode('/', $request->input('old_img'));
                $file_name = end($exlt_img);

                unlink(public_path("assets/pro_cate_icon/".$file_name));

                $image_resize = Image::make($image->getRealPath());              
                $image_resize->resize(350, 200);

                if(!File::exists(public_path()."/assets"))
                    File::makeDirectory(public_path()."/assets");

                if(!File::exists(public_path()."/assets/pro_cate_icon"))
                    File::makeDirectory(public_path()."/assets/pro_cate_icon");

                $image_resize->save(public_path("assets/pro_cate_icon/".$file_name));

                $main_category->where('id', $cate_id)->update(['cate_name' => $request->input('cate_name')]);

                return redirect()->route('single_record_main_category', ['data' => $cate_id])->with('msg', 'Record has been updated successfully.');
            } else{

                $main_category->where('id', $cate_id)->update(['cate_name' => $request->input('cate_name')]);

                return redirect()->route('single_record_main_category', ['data' => $cate_id])->with('msg', 'Record has been updated successfully.');
            }
        }
    }

    public function pro_cate_image ($filename) {

        $path = public_path('assets\pro_cate_icon\\'.$filename);

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
