<?php

namespace App\Http\Controllers\Auth\Shoplist;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Models\Shoplist\Shoplist;

class ShoplistController extends Controller
{
    /**
     * Show the form for creating a new shop.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('auth.shoplist.new_shop');
    }

    public function store(Request $request)
    {
        $request->validate([
            'location'   => 'required|string|max:255',
            'shop_name'  => 'required|string|max:255|unique:shoplist',
            'owner_name' => 'required|string|max:255',
            'contact'    => 'string|max:255|nullable',
            'address'    => 'string|max:255|nullable',
            'latitude'   => 'required|string|max:255',
            'longitude'  => 'required|string|max:255',
            'status'     => 'required|string|max:255',
        ],
		[
	        'location.required'   => 'The location is required',
	        'shop_name.required'  => 'The shop name is required',
	        'owner_name.required' => 'The owner name is required',
	        'contact.required'    => 'The contact is required',
	        'address.required'    => 'The address is required',
	        'latitude.required'   => 'The latitude is required',
	        'longitude.required'  => 'The longitude is required',
	    ]);

 
        //**saving in db**//
        $data = new Shoplist ;

        $data->location                     = $request->location;
        $data->shop_name                    = $request->shop_name;
        $data->owner_name                   = $request->owner_name;
        $data->contact                      = $request->contact;
        $data->address                      = $request->address;
        $data->latitude                     = $request->latitude;
        $data->longitude                    = $request->longitude;
        $data->status                       = $request->status;
        $data->created_at                   = now();
        $data->updated_at                   = now();

        $data->save();


        $insertedId = $data->id;
        Log::info('Shop Id:'.$insertedId.' Created Succesfully ');
         
        return redirect()->route('newshop')->with('msg', 'Shop has been created successfully');
    }

    /**
     * Display a listing of the shop list.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
        $data = Shoplist::get();

        return view('auth.shoplist.shoplist', compact('data'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vendordetails  $vendordetails
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
      
        $data = Shoplist::findOrFail( $id );
        $data->delete();

        return redirect('/shoplist');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vendordetails  $vendordetails
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $data = ShopList::findOrFail( $id );
       
        return view('auth/shoplist/edit_shop_details',compact('data','id'));                                 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vendordetails  $vendordetails
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $datacheck = ShopList::findOrFail( $id );

        //**if shop_name is not changed then won't check unique shop name**//
        if(($datacheck->shop_name)==($request->shop_name)){

              $request->validate([
                'location'   => 'required|string|max:255',
                'shop_name'  => 'required|string|max:255',
                'owner_name' => 'required|string|max:255',
                'contact'    => 'string|max:255|nullable',
                'address'    => 'string|max:255|nullable',
                'latitude'   => 'required|string|max:255',
                'longitude'  => 'required|string|max:255',
                'status'     => 'required|string|max:255',
            ]);

        }
        //**else check shop name uniqueness**//
        else{

            $request->validate([
                'location'   => 'required|string|max:255',
                'shop_name'  => 'required|string|max:255|unique:shoplist',
                'owner_name' => 'required|string|max:255',
                'contact'    => 'string|max:255|nullable',
                'address'    => 'string|max:255|nullable',
                'latitude'   => 'required|string|max:255',
                'longitude'  => 'required|string|max:255',
                'status'     => 'required|string|max:255',
            ]);
        }
         
        $data = ShopList::findOrFail( $id );

        $data->location                     = $request->location;
        $data->shop_name                    = $request->shop_name;
        $data->owner_name                   = $request->owner_name;
        $data->contact                      = $request->contact;
        $data->address                      = $request->address;
        $data->latitude                     = $request->latitude;
        $data->longitude                    = $request->longitude;
        $data->status                       = $request->status;
        $data->updated_at                   = now();

        $data->save();

        Log::info('Shop Id:'.$id.' Updated Succesfully');
        
        return redirect('/updateshop/'.$id)->with('msg', 'Shop Information has been updated successfully');
    }
}
