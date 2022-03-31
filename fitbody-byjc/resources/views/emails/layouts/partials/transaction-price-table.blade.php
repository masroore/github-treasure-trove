<table cellspacing="0" cellpadding="0" border="0" width="100%" style="margin-top: 20px;">
    <tr>
        <td>{{ __('mail.table.transfer') }}</td>
        <td class="ag-right">{{ number_format($transaction->order->ride->price_regular, 2, ',', '.') }} kn</td>
        <td class="ag-right">{{ number_format($transaction->order->ride->price_regular / app('hnb'), 2, ',', '.') }} €</td>
    </tr>
    @if ($transaction->order->ride->price_discount != 0)
        <tr>
            <td>{{ __('mail.table.discount') }}</td>
            <td class="ag-right">-{{ number_format($transaction->order->ride->price_discount, 2, ',', '.') }} kn</td>
            <td class="ag-right">{{ number_format($transaction->order->ride->price_discount / app('hnb'), 2, ',', '.') }} €</td>
        </tr>
    @endif
    <tr>
        <td style="text-transform: uppercase; font-weight: bolder;">{{ __('mail.table.total') }}</td>
        <td class="ag-right" style="font-weight: bolder;">{{ number_format($transaction->order->ride->price_total, 2, ',', '.') }} kn</td>
        <td class="ag-right" style="font-weight: bolder;">{{ number_format($transaction->order->ride->price_total / app('hnb'), 2, ',', '.') }} €</td>
    </tr>
</table>
