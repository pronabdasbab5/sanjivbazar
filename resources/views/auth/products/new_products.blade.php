@extends('layouts.dapp')

@section('content')
<div class="right_col" role="main">
  <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>New Product</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content"><br />
            <center>
                @if(session()->has('msg'))
                    <b>{{ session()->get('msg') }}</b>
                @endif
            </center>
            <!-- Section For New User registration -->
            <form method="POST" autocomplete="off" action="{{ url('newproducts') }}" class="form-horizontal form-label-left" enctype="multipart/form-data">
                @method('PUT')
                @csrf
              <div class="form-group">
                <label class="control-label col-md-2 col-sm-2 col-xs-12">Top-Category : <span class="required">*</span></label>
                <div class="col-md-4 col-sm-4 col-xs-12">
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
                <label class="control-label col-md-2 col-sm-2 col-xs-12">Sub-Category : <span class="required">*</span></label>
                <div class="col-md-4 col-sm-4 col-xs-12">
                  <select name="sub_cate_id" id="sub_cate_id"  class="form-control col-md-7 col-xs-12" required>
                      <option disabled selected>Choose Sub-Category...</option>
                  </select>
                    @error('sub_cate_id')
                        {{ $message }}
                    @enderror
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-2 col-sm-2 col-xs-12">Product Name : <span class="required">*</span></label>
                <div class="col-md-4 col-sm-4 col-xs-12">
                  <input type="text" name="pro_name" id="pro_name"  class="form-control col-md-7 col-xs-12" placeholder="Enter Product Name" autofocus>
                    @error('pro_name')
                        {{ $message }}
                    @enderror
                </div>
                <label class="control-label col-md-2 col-sm-2 col-xs-12">Date : <span class="required">*</span></label>
                <div class="col-md-4 col-sm-4 col-xs-12">
                  <input type="text" value="{{ date('d-m-Y') }}" class="form-control col-md-7 col-xs-12" disabled readonly>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-2 col-sm-2 col-xs-12">Product Image : <span class="required">*</span></label>
                <div class="col-md-4 col-sm-4 col-xs-12">
                  <input type="file" name="pro_img" id="pro_img" class="form-control col-md-7 col-xs-12" accept="image/*">
                    @error('pro_img')
                        {{ $message }}
                    @enderror
                </div>
                <label class="control-label col-md-2 col-sm-2 col-xs-12">Additional Images : <span class="required">*</span></label>
                <div class="col-md-4 col-sm-4 col-xs-12">
                  <input type="file" name="pro_add_img[]" id="pro_add_img" class="form-control col-md-7 col-xs-12" multiple  accept="image/*" required>
                    @error('pro_add_img')
                        {{ $message }}
                    @enderror
                </div> 
              </div>

              <div class="form-group">
                <label class="control-label col-md-2 col-sm-2 col-xs-12">Product Description : <span class="required">*</span></label>
                <div class="col-md-10 col-sm-10 col-xs-12">

                  <textarea name="pro_desc" class="desc" class="form-control col-md-7 col-xs-12"></textarea>
                    @error('pro_desc')
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

@section('script')
<script type="text/javascript">
    
$(document).ready(function(){

    $('#cate_id').change(function(){

        var cate_id = $('#cate_id').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        });

        $.ajax({
            method: "GET",
            url   : "{{ url('/ajax_retrive_subcategory/') }}/"+cate_id+"",
            success: function(response) {

                $('#sub_cate_id').html(response);
            }
        });
    });
});
</script>
@endsection

