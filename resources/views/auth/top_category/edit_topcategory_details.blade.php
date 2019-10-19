@extends('layouts.dapp')

@section('content')
<div class="right_col" role="main">
  <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Update Top-Category details</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content"><br />
            <center>
                @if(session()->has('msg'))
                    <b>{{ session()->get('msg') }}</b>
                @endif
                <br>
                <img src="{{ $data[0]['img_path'] }}" alt="Top-Category Image" height="100" width="200" name="main_cate_img" id="main_cate_img">
            </center>
            <!-- Section For New User registration -->
            <form method="POST" autocomplete="off" action="{{ url('/updatetopcategory/'.$data[0]['id']) }}" class="form-horizontal form-label-left" enctype="multipart/form-data">
                @method('PUT')
                @csrf
              <div class="form-group">
                <label class="control-label col-md-2 col-sm-2 col-xs-12">Top-Category : <span class="required">*</span></label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <input type="text"  name="cate_name" id="cate_name" class="form-control col-md-7 col-xs-12" placeholder="Enter Top-Category" value="{{ $data[0]['cate_name'] }}">
                  <input type="hidden"  name="old_img" id="old_img" value="{{ $data[0]['img_path'] }}">
                    @error('cate_name')
                        {{ $message }}
                    @enderror
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-2 col-sm-2 col-xs-12">Category Icon : <span class="required">*</span></label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <input type="file"  name="icon" id="icon"  class="form-control col-md-7 col-xs-12">
                    @error('icon')
                        {{ $message }}
                    @enderror
                </div>
              </div>

              <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="submit" name="submit" class="btn btn-success">Update</button>
                    <a href="{{ route('topcategorylist') }}" class="btn btn-warning">Back</a>
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

@section('script')
<script type="text/javascript">
$('#icon').change(function(e){

    var url = URL.createObjectURL(e.target.files[0]);
    $('#main_cate_img').attr('src', url);
});
</script>
@endsection