
@extends('layouts.dapp')

@section('content')
<!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="row top_tiles">
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-users"></i></div>
                  <div class="count">
                    {{-- {{ ($usersCnt > 0)? $usersCnt: 0 }} --}}
                  </div>
                  <h3>Total</h3>
                  <p>Users</p>
                </div>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-list-alt"></i></div>
                  <div class="count">
                    {{-- {{ ($categoryCnt > 0)? $categoryCnt: 0 }} --}}
                  </div>
                  <h3>Total</h3>
                  <p>Category</p>
                </div>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-shopping-cart"></i></div>
                  <div class="count">
                    {{-- {{ ($orderCnt > 0)? $orderCnt: 0 }} --}}
                  </div>
                  <h3>Total</h3>
                  <p>Order</p>
                </div>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-houzz"></i></div>
                  <div class="count">
                   {{--  {{ ($productCnt > 0)? $productCnt: 0 }} --}}
                  </div>
                  <h3>Total</h3>
                  <p>Products</p>
                </div>
              </div>
            </div>
          </div>

            </br>
        </div>
        <!-- /page content -->
@endsection
