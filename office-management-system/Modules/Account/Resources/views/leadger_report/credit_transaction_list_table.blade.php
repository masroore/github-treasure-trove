<table class="table">
    <thead>
        <tr>
            <th scope="col">{{ __('account.Date') }}</th>
            <th scope="col">{{__('account.Reference No.')}}</th>
            <th scope="col">{{ __('account.Description') }}</th>
            <th scope="col">{{ __('account.Debit') }}</th>
            <th scope="col">{{ __('account.Credit') }}</th>
            <th scope="col" class="text-right">{{ __('account.Balance') }}</th>
        </tr>
    </thead>
    <tbody>
        @php
         $currentBalance = 0 + $balance + $opening_balance;
        @endphp
        <tr>
            <td>{{ __('account.Openning Balance') }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-right">{{ single_price($currentBalance) }}</td>
        </tr>
        @foreach ($transactions->sort() as $key => $payment)
            @if ($payment->type != "Cr")
                @php
                    $currentBalance -= $payment->amount;
                @endphp
            @else
                @php
                    $currentBalance += $payment->amount;
                @endphp
            @endif
            <tr>
                <td>{{ date(app('general_setting')->dateFormat->format, strtotime(@$payment->voucherable->date)) }}</td>
                <td><a onclick="voucher_detail({{ $payment->voucherable->id }})">{{ (@$payment->voucherable->referable->invoice_no) ? @$payment->voucherable->referable->invoice_no : @$payment->voucherable->tx_id }}</a></td>
                <td>{{ @$payment->voucherable->narration }}</td>
                <td>
                    @if ($payment->type == "Dr")
                        {{ single_price($payment->amount) }}
                        <input type="hidden" name="debit[]" value="{{ $payment->amount }}">
                    @endif
                </td>
                <td>
                    @if ($payment->type == "Cr")
                        {{ single_price($payment->amount) }}
                        <input type="hidden" name="credit[]" value="{{ $payment->amount }}">
                    @endif
                </td>
                <td class="text-right">{{ single_price($currentBalance) }}</td>
            </tr>
        @endforeach
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>{{ __('account.Total') }}</td>
            <td class="text-right">{{ single_price($currentBalance) }}</td>
        </tr>
    </tbody>
</table>
