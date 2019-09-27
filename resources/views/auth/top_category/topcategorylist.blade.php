@extends('layouts.dapp')

@section('content')
<div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>All Top-Category</h2>
                    <a href="{{ route('newtopcategory') }}" style="float: right; font-weight: bolder; font-size: 18px;">New Top-Category</a>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
					
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>Image</th>
                            <th>Top-Category</th>
                            <th>Status</th>
                            <th>Add Date</th>
                            <th>Edit</th>
                        </tr>
                      </thead>
                      <tbody>
                        @if (count($data) > 0)

                            @foreach ($data as $value)

                                <tr>
                                    <td>{{$value['id']}}</td>
                                    <td><img src="{{ $value['img_path'] }}" width="90" /></td>
                                    <td><b>{{$value['cate_name'] }}</b></td>
                                    <td>
                                        <a href="{{ route('topcategory_change_status', ['id' => $value['id']]) }}" class="btn btn-primary" style="font-weight: bold;">
                                           @if($value['status'] == 1)
                                                {{ "De-Actiive" }}
                                            @else
                                                {{ "Actiive" }}
                                            @endif 
                                        </a>
                                    </td>
                                    <td>{{$value['created_at']}}</td>
                                    <td>
                                        <a href="/updatetopcategory/{{ $value['id'] }}" class="btn btn-warning">Edit Info.</a>
                                    </td>
                                </tr> 
                            @endforeach
                        @endif
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
@endsection