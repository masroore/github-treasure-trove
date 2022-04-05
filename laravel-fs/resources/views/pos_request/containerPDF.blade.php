<div class="content-table">

    <h3>{{  __('POS Request')  }}</h3>

		<iframe src="{{route('pos_request.viewPDF', $Request->crypt_id)}}" title="posRequestPDF" width="100%" height="500"> </iframe>
</div>


