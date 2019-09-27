<?php

namespace App\Http\Controllers\Auth\Size;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Size\Size;
use App\Models\Subsize\Subsize;
use App\Models\Subcategory\Subcategory;
use DB;

class SizeController extends Controller
{
    public function create () {

    	$size      = new Size;
    	$size_data = $size->all();

    	return view('auth.size.new_size', ['data' => $size_data]);
    }

    public function store (Request $request) {

    	$request->validate([
	        'size' => 'required'
	    ],
		[
	        'size.required' => 'The size is required'
	    ]);

    	$size      = new Size;
        $row_check = $size->where('size', ucwords(strtolower($request->input('size'))))->count();

        if ($row_check > 0) 
            return redirect('/newsize')->with('msg', 'Record already available.');
        else {

            $size->size = ucwords(strtolower($request->input('size')));

            if($size->save()) 
                return redirect('/newsize')->with('msg', 'Size has been added successfully');
            else
                return redirect('/newsize')->with('msg', 'Something wrong while adding'); 
        }
    }

    public function update (Request $request, $size_id) {

        if ($request->has('size_name')) {

            $size     = new Size;
            $row_size = $size->where('size', $request->input('size_name'))->count();

            if ($row_size > 1)
                print "1";
            else {

                $size->where('id', $size_id)->update(['size' => ucwords(strtolower($request->input('size_name')))]);
                print "1";
            }
        } else
            print "2";
    }

    public function create_mapping_size () {

        $sub_category      = new Subcategory;
        $sub_category_data = $sub_category->all();

        $size      = new Size;
        $size_data = $size->all();

        $sub_size_data = DB::table('sub_size')
                            ->join('size', 'sub_size.size_id', '=', 'size.id')
                            ->join('sub_category', 'sub_size.sub_cate_id', '=', 'sub_category.id')
                            ->select('sub_size.sub_cate_id', 'sub_size.id', 'sub_size.size_id', 'size.size', 'sub_size.status', 'sub_size.created_at', 'sub_category.sub_cate_name')
                            ->get();

        return view('auth.size.mapping_size', ['size' => $size_data, 'sub_category' => $sub_category_data, 'sub_size_data' => $sub_size_data]);
    }

    public function store_mapping_size (Request $request) {

        $request->validate([
            'sub_cate_id' => 'bail|required',
            'size_id'     => 'required'
        ],
        [
            'sub_cate_id.required' => 'The Sub-Category is required',
            'size_id.required'    => 'The size is required'
        ]);

        $subsize   = new Subsize;
        $row_check = $subsize->where('sub_cate_id', $request->input('sub_cate_id'))
                            ->where('size_id', $request->input('size_id'))
                            ->count();

        if ($row_check > 0)
            return redirect('/newmapping_size')->with('msg', 'Record already available.');
        else {

            $subsize->size_id     = $request->input('size_id');
            $subsize->sub_cate_id = $request->input('sub_cate_id');
            $subsize->id          = $subsize->count() + 1;

            if($subsize->save()) 
                return redirect('/newmapping_size')->with('msg', 'Mapping has been added successfully');
            else
                return redirect('/newmapping_size')->with('msg', 'Something wrong while mapping'); 
        }
    }

    public function change_status($id) {

        $subsize = new Subsize;
        $subsize = $subsize->find($id);

        if($subsize->status == "0") {

            $subsize->update(['status' => "1"]);
        }
        else {

            $subsize->update(['status' => "0"]);
        }

        $sub_category      = new Subcategory;
        $sub_category_data = $sub_category->all();

        $size      = new Size;
        $size_data = $size->all();

        $sub_size_data = DB::table('sub_size')
                            ->join('size', 'sub_size.size_id', '=', 'size.id')
                            ->join('sub_category', 'sub_size.sub_cate_id', '=', 'sub_category.id')
                            ->select('sub_size.sub_cate_id', 'sub_size.id', 'sub_size.size_id', 'size.size', 'sub_size.status', 'sub_size.created_at', 'sub_category.sub_cate_name')
                            ->get();

        return view('auth.size.mapping_size', ['size' => $size_data, 'sub_category' => $sub_category_data, 'sub_size_data' => $sub_size_data]);
    }

}
