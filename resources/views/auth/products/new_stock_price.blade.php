@extends('layouts.dapp')

@section('content')
<div class="right_col" role="main">
  <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>New Stock-Price</h2>
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
                <label class="control-label col-md-1 col-sm-1 col-xs-12">Brands : <span class="required">*</span></label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <select name="brand_id" id="brand_id"  class="form-control col-md-7 col-xs-12" required>
                      <option disabled selected>Choose Brands...</option>
                      {{-- @if(!$brands->isEmpty())
                        @foreach($brands as $key => $value)
                            <option value="{{ $value['id'] }}">{{ $value['brands'] }}</option>
                        @endforeach
                      @endif --}}
                  </select>
                    @error('brand_id')
                        {{ $message }}
                    @enderror
                </div>
                <label class="control-label col-md-1 col-sm-1 col-xs-12">Size : <span class="required">*</span></label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <select name="size_id" id="size_id"  class="form-control col-md-7 col-xs-12" required>
                      <option disabled selected>Choose Size...</option>
                      {{-- @if(!$size->isEmpty())
                        @foreach($size as $key => $value)
                            <option value="{{ $value['id'] }}">{{ $value['size'] }}</option>
                        @endforeach
                      @endif --}}
                  </select>
                    @error('size_id')
                        {{ $message }}
                    @enderror
                </div>
                <label class="control-label col-md-1 col-sm-1 col-xs-12">Shop : <span class="required">*</span></label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <select name="shop_id" id="shop_id"  class="form-control col-md-7 col-xs-12" required>
                      <option disabled selected>Choose Shop...</option>
                      {{-- @if(!$shop->isEmpty())
                        @foreach($shop as $key => $value)
                            <option value="{{ $value['id'] }}">{{ $value['shop_name'] }}</option>
                        @endforeach
                      @endif --}}
                  </select>
                    @error('shop_id')
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

