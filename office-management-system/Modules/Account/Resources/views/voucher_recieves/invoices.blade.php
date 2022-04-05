@if (isset($selected_invoice_id))
    <select class="primary_select mb-15 payment_from" name="invoice_id" id="invoice_id" required>
        <option value="0">{{__('common.Select One')}}</option>
        @foreach ($inovices as $key => $inovice)
            <option value="{{ $inovice->id }}" @if ($selected_invoice_id == $inovice->id) selected @endif>{{ $inovice->invoice_no }} - ({{ $inovice->payments()->exists() ? single_price($inovice->payable_amount - $inovice->payments()->sum('amount')) : single_price($inovice->payable_amount) }})</option>
        @endforeach
    </select>
@else
    <select class="primary_select mb-15 payment_from" name="invoice_id" id="invoice_id" required>
        <option value="0">{{__('common.Select One')}}</option>
        @foreach ($inovices as $key => $inovice)
            <option value="{{ $inovice->id }}">{{ $inovice->invoice_no }} - ({{ $inovice->payments()->exists() ? single_price($inovice->payable_amount - $inovice->payments()->sum('amount')) : single_price($inovice->payable_amount) }})</option>
        @endforeach
    </select>
@endif
