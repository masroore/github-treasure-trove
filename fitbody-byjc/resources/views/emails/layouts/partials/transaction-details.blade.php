<h3>{{ __('mail.details.title') }}:</h3>
<table cellspacing="0" cellpadding="0" border="0" width="100%">
    <tr>
        <td style="width: 40%">{{ __('mail.details.name') }}:</td>
        <td style="width: 60%"><b>{{ $transaction->fname . ' ' . $transaction->lname }}</b></td>
    </tr>
    <tr>
        <td>{{ __('mail.details.address') }}:</td>
        <td><b>{{ $transaction->address }}</b></td>
    </tr>
    <tr>
        <td>{{ __('mail.details.city') }}:</td>
        <td><b>{{ $transaction->zip . ' ' . $transaction->city . ', ' . $transaction->state }}</b></td>
    </tr>
    <tr>
        <td>{{ __('mail.details.email') }}:</td>
        <td><b>{{ $transaction->email }}</b></td>
    </tr>
    <tr>
        <td>{{ __('mail.details.phone') }}:</td>
        <td><b>{{ ($transaction->phone) ? $transaction->phone : '' }}</b></td>
    </tr>
    <tr>
        <td>{{ __('mail.details.vehicle') }}:</td>
        <td><b>{{ (app()->getLocale() == 'en') ? str_replace('Vozilo', 'Vehicle', $transaction->order->vehicle->name) : $transaction->order->vehicle->name }}</b></td>
    </tr>
    <tr>
        <td>{{ __('mail.details.start') }}:</td>
        <td><b>{{ $transaction->order->ride->address_start }}</b></td>
    </tr>
    <tr>
        <td>{{ __('mail.details.date_start') }}:</td>
        <td><b>{{ \Illuminate\Support\Carbon::make($transaction->order->ride->datetime)->format('d.m.Y. H:i') }}</b></td>
    </tr>
    <tr>
        <td>{{ __('mail.details.end') }}:</td>
        <td><b>{{ $transaction->order->ride->address_end }}</b></td>
    </tr>
    @if ($transaction->order->ride->type == 'return')
        <tr>
            <td>{{ __('mail.details.date_return') }}:</td>
            <td><b>{{ \Illuminate\Support\Carbon::make($transaction->order->ride->datetime_2)->addHour()->format('d.m.Y. H:i') }}</b></td>
        </tr>
    @endif
    <tr>
        <td>{{ __('mail.details.passangers') }}:</td>
        <td><b>{{ $transaction->order->ride->passangers }}</b></td>
    </tr>

    @if ($transaction->order->ride->start_flight != '')
        <tr>
            <td>{{ __('payment.form.flight') }}:</td>
            <td><strong>{{ ($transaction->order->ride->start_flight) ? $transaction->order->ride->start_flight : '' }}</strong></td>
        </tr>
    @endif
    @if ($transaction->order->ride->end_flight != '')
        <tr>
            <td>{{ __('payment.form.flight_end') }}:</td>
            <td><strong>{{ ($transaction->order->ride->end_flight) ? $transaction->order->ride->end_flight : '' }}</strong></td>
        </tr>
    @endif
    @if ($transaction->order->ride->info != '')
        <tr>
            <td>Info:</td>
            <td><strong>{{ ($transaction->order->ride->info) ? $transaction->order->ride->info : '' }}</strong></td>
        </tr>
    @endif

    @if ($transaction->order->ride->start_flight_2 != '')
        <tr>
            <td>{{ __('payment.form.flight_return') }}:</td>
            <td><strong>{{ ($transaction->order->ride->start_flight_2) ? $transaction->order->ride->start_flight_2 : '' }}</strong></td>
        </tr>
    @endif
    @if ($transaction->order->ride->end_flight_2 != '')
        <tr>
            <td>{{ __('payment.form.flight_return_end') }}:</td>
            <td><strong>{{ ($transaction->order->ride->end_flight_2) ? $transaction->order->ride->end_flight_2 : '' }}</strong></td>
        </tr>
    @endif
    @if ($transaction->order->ride->info_2 != '')
        <tr>
            <td>Info:</td>
            <td><strong>{{ ($transaction->order->ride->info_2) ? $transaction->order->ride->info_2 : '' }}</strong></td>
        </tr>
    @endif

</table>
