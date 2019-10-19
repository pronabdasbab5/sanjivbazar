@extends('layouts.dapp')

@section('content')
<div class="right_col" role="main">
  <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>New Brands</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content"><br />
            <center>
                @if(session()->has('msg'))
                    <b>{{ session()->get('msg') }}</b>
                @endif
            </center>
            <!-- Section For New User registration -->
            <form method="POST" autocomplete="off" action="{{ url('/newbrands') }}" class="form-horizontal form-label-left" enctype="multipart/form-data">
                @csrf
            <div class="form-group">
                <label class="control-label col-md-2 col-sm-2 col-xs-12">Brands : <span class="required">*</span></label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <input type="text" name="brands" id="brands"  class="form-control col-md-7 col-xs-12" placeholder="Enter Brands" autofocus>
                    @error('brands')
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
                    <h2>Available Brands</h2>
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
                            <th>Brands</th>
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
                                    <td>{{ ++$sl_no }}</td>
                                    <td>{{$value['brands'] }}</td>
                                    <td>{{$value['created_at']}}</td>
                                    <td>
                                        <a class="btn btn-primary" id="brand_edit_id{{$value['id']}}" onclick="edit_brand_model({{$value['id']}});">Edit Info.</a>
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

@section('script')
<script type="text/javascript">
function edit_brand_model(brand_id) {

    $('#brands_details').html("<center><b style=\"font-size: 20px;\">Loading ....</b></center>");

    $('#brands_modal').modal('show');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    });

    $.ajax({
        method: "GET",
        url   : "{{ url('/updatebrands/') }}/"+brand_id+"",
        success: function(response) {

            $('#brands_details').html(response);
        }
    });
}

function save_brand_info() {

    var brand_id   = $('#brand_id_modal').text();
    var brand_name = $('#brand_name_modal').val();

    $('#btn_save_brand_info').text('Updating ... ! Please wait');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    });

    if(brand_name != ""){

        $.ajax({
            method: "POST",
            url   : "{{ url('/updatebrands') }}/"+brand_id,
            data: {

                "brand_id": brand_id,
                "brand_name": brand_name
            },
            success: function(response) {

                if(response == "1") {

                    $('#brands_modal').modal('hide');
                    location.reload();
                }
                else {

                    $('#brand_name_text').text('Please ! Enter brand name.');
                    $('#btn_save_brand_info').text('Save');
                }
            }
        });
    } else{

        $('#brand_name_text').text('Please ! Enter brand name.');
        $('#btn_save_brand_info').text('Update');
    }

}
</script>
@endsection