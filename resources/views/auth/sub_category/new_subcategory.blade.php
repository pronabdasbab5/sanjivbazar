@extends('layouts.dapp')

@section('content')
<div class="right_col" role="main">
  <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>New Sub-Category</h2>
            <a href="{{ route('subcategorylist') }}" style="float: right; font-weight: bolder; font-size: 18px;">All Sub-Category</a>
            <div class="clearfix"></div>
          </div>
          <div class="x_content"><br />
            <center>
                @if(session()->has('msg'))
                    <b>{{ session()->get('msg') }}</b>
                @endif
            </center>
            <!-- Section For New User registration -->
            <form method="POST" autocomplete="off" action="{{ url('/newsubcategory') }}" class="form-horizontal form-label-left" enctype="multipart/form-data">
                @method('PUT')
                @csrf
              <div class="form-group">
                <label class="control-label col-md-2 col-sm-2 col-xs-12">Top-Category : <span class="required">*</span></label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <select name="cate_id" id="cate_id"  class="form-control col-md-7 col-xs-12" required>
                      <option disabled selected>Choose Top-Category...</option>
                      @if(!$data->isEmpty())
                        @foreach($data as $key => $value)
                            <option value="{{ $value['id'] }}">{{ $value['cate_name'] }}</option>
                        @endforeach
                      @endif
                  </select>
                    @error('cate_id')
                        {{ $message }}
                    @enderror
                </div>
              </div>

            <div class="form-group">
                <label class="control-label col-md-2 col-sm-2 col-xs-12">Sub-Category : <span class="required">*</span></label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <input type="text" name="sub_cate_name" id="sub_cate_name"  class="form-control col-md-7 col-xs-12" placeholder="Enter Sub-Category" autofocus>
                    @error('sub_cate_name')
                        {{ $message }}
                    @enderror
                </div>
            </div>


              <div class="form-group">
                <label class="control-label col-md-2 col-sm-2 col-xs-12">Sub-Category Icon : <span class="required">*</span></label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <input type="file" name="sub_icon" id="sub_icon" class="form-control col-md-7 col-xs-12" autofocus>
                    @error('sub_icon')
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
</div>
@endsection