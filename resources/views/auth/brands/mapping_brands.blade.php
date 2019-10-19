@extends('layouts.dapp')

@section('content')
<div class="right_col" role="main">
  <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>New Mapping Brands</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content"><br />
            <center>
                @if(session()->has('msg'))
                    <b>{{ session()->get('msg') }}</b>
                @endif
            </center>
            <!-- Section For New User registration -->
            <form method="POST" autocomplete="off" action="{{ url('/newmapping_brands') }}" class="form-horizontal form-label-left">
                @csrf
              <div class="form-group">
                <label class="control-label col-md-2 col-sm-2 col-xs-12">Sub-Category : <span class="required">*</span></label>
                <div class="col-md-4 col-sm-4 col-xs-12">
                  <select name="sub_cate_id" id="sub_cate_id"  class="form-control col-md-7 col-xs-12" required>
                      <option disabled selected>Choose Sub-Category...</option>
                      @if(!$sub_category->isEmpty())
                        @foreach($sub_category as $key => $value)
                            <option value="{{ $value['id'] }}">{{ $value['sub_cate_name'] }}</option>
                        @endforeach
                      @endif
                  </select>
                    @error('sub_cate_id')
                        {{ $message }}
                    @enderror
                </div>
                <label class="control-label col-md-2 col-sm-2 col-xs-12">Brands : <span class="required">*</span></label>
                <div class="col-md-4 col-sm-4 col-xs-12">
                  <select name="brand_id" id="brand_id"  class="form-control col-md-7 col-xs-12" required>
                      <option disabled selected>Choose Brands...</option>
                      @if(!$brands->isEmpty())
                        @foreach($brands as $key => $value)
                            <option value="{{ $value['id'] }}">{{ $value['brands'] }}</option>
                        @endforeach
                      @endif
                  </select>
                    @error('brand_id')
                        {{ $message }}
                    @enderror
                </div>
              </div>

              <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="submit" name="submit" class="btn btn-success">Create</button>
                  </div>
                </div>
            </form>
            <!-- End New User registration -->
            </div>
          </div>
        </div>
      </div>

      <div class="clearfix"></div>

            <!-- Modal -->
            <div class="modal fade" id="brands_modal" role="dialog" style="margin-top: 50px;">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title" id="modal_title">Edit Brands</h4>
                        </div>
                        <div class="modal-body" id="brands_details">
                            <center><b style="font-size: 20px;">Loading ....</b></center>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Available Sub-Category and Brands</h2>
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
                            <th>Sub-Category</th>
                            <th>Brands</th>
                            <th>Add Date</th>
                            <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        @if (count($sub_brands_data) > 0)

                            @php
                            $sl_no = 0;
                            @endphp

                            @foreach ($sub_brands_data as $value)

                                @if($value->status == 0)
                                    @php
                                        $status = "Active"
                                    @endphp
                                @else
                                    @php
                                        $status = "De-Active"
                                    @endphp
                                @endif

                                <tr>
                                    <td>{{ ++$sl_no }}</td>
                                    <td>{{ $value->sub_cate_name }}</td>
                                    <td>{{ $value->brands }}</td>
                                    <td>{{ $value->created_at}}</td>
                                    <td>
                                        <a class="btn btn-primary" href="{{ route('mapping_brands_change_status', ['id' => $value->id]) }}" style="font-weight: bold;">{{ $status }}</a>
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
@endsection