@extends('layouts.dashboard.app')

@section('content')
<div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>All Main Category</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
					
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>Main Category</th>
                            <th>Image</th>
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
                                    <td>{{$value['cate_name'] }}</td>
                                    <td><img src="{{ $value['img_path'] }}" width="70" height="70" /></td>
                                    <td>
                                        <a href="{{ route('change_status_main_category', ['id' => $value['id']]) }}">
                                           @if($value['status'] == 1)
                                                {{ "Actiive" }}
                                            @else
                                                {{ "Inactiive" }}
                                            @endif 
                                        </a>
                                    </td>
                                    <td>{{$value['created_at']}}</td>
                                    <td>
                                        <a href="{{ route('single_record_main_category', ['id' => $value['id']]) }}">Edit Info.</a>
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