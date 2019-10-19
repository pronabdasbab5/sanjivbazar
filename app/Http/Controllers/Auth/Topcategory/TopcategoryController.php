<?php

namespace App\Http\Controllers\Auth\Topcategory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Models\Topcategory\Topcategory;
use Intervention\Image\ImageManagerStatic as Image;
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
        return view('auth.top_category.new_topcategory');
    }

    public function store (Request $request) {

    	$request->validate([
	        'cate_name' => 'required',
            'icon' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
	    ],
		[
	        'cate_name.required' => 'The main category is required',
            'icon.required' => 'Please ! Upload valid image.'
	    ]);

    	$top_category = new Topcategory;
        $row_check    = $top_category->where('cate_name', $request->input('cate_name'))->count();

        if ($row_check > 0)
            return redirect()->route('newtopcategory')->with('msg', 'Record already available.');
        else {

            if($request->hasFile('icon')) {

                $image     = $request->file('icon');
                $file_name = time().".jpg";

                $image_resize = Image::make($image->getRealPath());              
                $image_resize->resize(350, 200);

                if(!File::exists(public_path()."/assets"))
                    File::makeDirectory(public_path()."/assets");

                if(!File::exists(public_path()."/assets/pro_cate_icon"))
                    File::makeDirectory(public_path()."/assets/pro_cate_icon");

                $image_resize->save(public_path("assets/pro_cate_icon/".$file_name));
                $top_category->cate_name = ucwords(strtolower($request->input('cate_name')));
                $top_category->img_path = $file_name;
                $top_category->id = $top_category->count() + 1;

                if($top_category->save()) 
                    return redirect()->route('newtopcategory')->with('msg', 'Category has been added successfully');
                else
                    return redirect()->route('newtopcategory')->with('msg', 'Something wrong while adding'); 

            } else
                return redirect()->route('newtopcategory')->with('msg', 'Please ! upload image.');  
        }
    }

    public function index () {

        $top_category      = new Topcategory;
        $top_category_data = $top_category->all();

        $data = null;

        foreach ($top_category_data as $key => $value) {

            $url = route('pro_cate_image', ['filename' => $value['img_path']]);
            
            $data [] = [
                "id"         => $value['id'],
                "cate_name"  => $value['cate_name'],
                "img_path"   => $url,
                "status"     => $value['status'],
                "created_at" => $value['created_at']
            ];
        }

        return view('auth.top_category.topcategorylist', ['data' => $data]);
    }

    public function change_status($id) {

        $top_category = new Topcategory;
        $top_category = $top_category->find($id);

        if($top_category->status == "0")
            $top_category->update(['status' => "1"]);
        else 
            $top_category->update(['status' => "0"]);

        $top_category_data = $top_category->all();

        $data = null;

        foreach ($top_category_data as $key => $value) {

            $url = route('pro_cate_image', ['filename' => $value['img_path']]);
            
            $data [] = [
                "id"         => $value['id'],
                "cate_name"  => $value['cate_name'],
                "img_path"   => $url,
                "status"     => $value['status'],
                "created_at" => $value['created_at']
            ];
        }

        return view('auth.top_category.topcategorylist', ['data' => $data]);
    }

    public function edit ($id) {

        $top_category = new Topcategory;
        $top_category = $top_category->find($id);

        $url = route('pro_cate_image', ['filename' => $top_category->img_path]);

        $data = null;
            
        $data [] = [
            "id"        => $top_category->id,
            "cate_name" => $top_category->cate_name,
            "img_path"  => $url
        ];

        return view('auth.top_category.edit_topcategory_details', ['data' => $data]);
    }

    public function update (Request $request, $cate_id) {

        $request->validate([
            'cate_name' => 'required',
            'icon' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ],
        [
            'cate_name.required' => 'The main category is required',
        ]);

        $top_category = new Topcategory;
        $row_check    = $top_category->where('cate_name', $request->input('cate_name'))->count();

        if ($row_check > 0) {

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

                return redirect('/updatetopcategory/'.$cate_id)->with('msg', 'Record has been updated successfully.');
            } else
                return redirect('/updatetopcategory/'.$cate_id)->with('msg', 'File is empty.');
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

                $top_category->where('id', $cate_id)->update(['cate_name' => ucwords(strtolower($request->input('cate_name')))]);

                return redirect('/updatetopcategory/'.$cate_id)->with('msg', 'Record has been updated successfully.');
            } else{

                $top_category->where('id', $cate_id)->update(['cate_name' => ucwords(strtolower($request->input('cate_name')))]);

                return redirect('/updatetopcategory/'.$cate_id)->with('msg', 'Record has been updated successfully.');
            }
        }
    }

    public function pro_cate_image ($filename) {

        $path = public_path('assets\pro_cate_icon\\'.$filename);

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
