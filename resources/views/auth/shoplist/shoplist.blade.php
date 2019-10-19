@extends('layouts.dapp')
@section('content')
<div class="right_col" role="main">
	<div class="clearfix"></div>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>All Shops</h2>
                    <a href="{{ route('newshop') }}" style="float: right; font-weight: bolder; font-size: 18px;">Add New Shop</a>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                            <th>Sl No.</th>
                            <th>Shop Name</th>
                            <th>Owner Name</th>
                            <th>Contact</th>
                            <th>Adrress</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Delete</th>
                            <th>Modify</th>
                        </tr>
                      </thead>


                      <tbody>
                        @foreach($data as $sl=>$dt)
                            <tr>
                                <td>{{ $sl + 1 }}</td>
                                <td>{{ $dt->shop_name }}</td>
                                <td>{{ $dt->owner_name }}</td>
                                <td>{{ $dt->contact }}</td>
                                <td>{{ $dt->address }}</td>
                                <td>{{ $dt->location }}</td>
                                <td>{{ $dt->status }}</td>
                                <td >
                                    <a title="Delete" href="/deleteshop/{{$dt->id}}" id="{{$dt->id}}" onclick="return confirm('Are you sure you want to delete this details?');"><button type = "button" title="Delete" class = "btn btn-danger btn-sm">
                                      <i class="fa fa-minus-circle"></i>&nbsp;&nbsp;Delete
                                    </button></a>
                                </td>
                                <td>
                                    <a title="Edit" href="/updateshop/{{$dt->id}}" id="{{$dt->id}}"><button type = "button" title="Edit" class = "btn btn-info btn-sm">
                                      <i class="fa fa-edit"></i>&nbsp;&nbsp;Modify
                                    </button></a>
                                </td>
                            </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
		</div>
@endsection

