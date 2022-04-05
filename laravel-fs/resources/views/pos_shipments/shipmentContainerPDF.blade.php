<div class="content-table">

    <h3>{{  __('POS Shipment')  }}</h3>

		<iframe src="{{route('pos_send_request.shipmentPDF', $Request->crypt_id)}}"  width="100%" height="500"> </iframe>
</div>


