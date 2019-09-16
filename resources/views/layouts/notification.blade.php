<li role="presentation" class="dropdown">
    <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
        <i class="fa fa-envelope-o"></i>
        <span class="badge bg-green">
        	{{-- ({{ ($newOrderReviewData['newOrderData'] + $newOrderReviewData['newReviewData']) > 0? ($newOrderReviewData['newOrderData'] + $newOrderReviewData['newReviewData']): 0  }}) --}}
        </span>{{-- 
        @if($newOrderReviewData['newOrderData'] > 0 || $newOrderReviewData['newReviewData'] > 0)
        	<ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
        		@if($newOrderReviewData['newOrderData'] > 0)
        			<li><a href="{{ route('new_orders') }}"><b>({{ $newOrderReviewData['newOrderData'] }}) New Orders</b></a></li>
        		@endif
        		@if($newOrderReviewData['newReviewData'] > 0)
        			<li><a href="{{ route('new_review') }}"><b>({{ $newOrderReviewData['newReviewData'] }}) New Reviews</b></a></li>
        		@endif
        	</ul>
        @endif --}}
    </a>
</li>