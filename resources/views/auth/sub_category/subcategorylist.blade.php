@extends('layouts.dapp')

@section('content')
<div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>All Sub-Category</h2>
                    <a href="{{ route('newsubcategory') }}" style="float: right; font-weight: bolder; font-size: 18px;">New Sub-Category</a>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
					
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>Top-Category</th>
                            <th>Top-Category Status</th>
                            <th>Sub-Category</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Add Date</th>
                            <th>Edit</th>
                        </tr>
                      </thead>
                      <tbody>
                        @if (count($data) > 0)

                            @php
                            $sl_no = 0;
                            @endphp

                            @foreach ($data as $value)

                                <tr>
                                    <td>{{ $sl_no++ }}</td>
                                    <td>{{ $value['top_cate_name'] }}</td>
                                    <td>
                                        @if($value['top_cate_status'] == 1)
                                            {{ "Actiive" }}
                                        @else
                                            {{ "Inactiive" }}
                                        @endif 
                                    </td>
                                    <td>{{ $value['sub_cate_name'] }}</td>
                                    <td><img src="{{ $value['img_path'] }}" width="70" height="70" /></td>
                                    <td>
                                        <a href="{{ route('subcategorychange_status', ['id' => $value['sub_cate_id']]) }}" class="btn btn-primary" style="font-weight: bold;">
                                           @if($value['status'] == 1)
                                                {{ "De-Actiive" }}
                                            @else
                                                {{ "Actiive" }}
                                            @endif 
                                        </a>
                                    </td>
                                    <td>{{$value['created_at']}}</td>
                                    <td>
                                        <a href="/updatesubcategory/{{ $value['sub_cate_id'] }}" class="btn btn-warning" style="font-weight: bold;">Edit Info.</a>
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