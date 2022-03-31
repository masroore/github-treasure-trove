<h3>{{ __('mail.details.title') }}:</h3>
<table cellspacing="0" cellpadding="0" border="0" width="100%">
    <tr>
        <td style="width: 40%">{{ __('mail.details.name') }}:</td>
        <td style="width: 60%"><b>{{ $order->user->fname . ' ' . $order->user->lname }}</b></td>
    </tr>
    <tr>
        <td>{{ __('mail.details.address') }}:</td>
        <td><b>{{ $order->user->address }}</b></td>
    </tr>
    <tr>
        <td>{{ __('mail.details.city') }}:</td>
        <td><b>{{ $order->user->zip . ' ' . $order->user->city . ', ' . $order->user->state }}</b></td>
    </tr>
    <tr>
        <td>{{ __('mail.details.email') }}:</td>
        <td><b>{{ $order->user->email }}</b></td>
    </tr>
    <tr>
        <td>{{ __('mail.details.phone') }}:</td>
        <td><b>{{ ($order->user->mobile) ? $order->user->mobile : '' }}</b></td>
    </tr>
    <tr>
        <td>{{ __('mail.details.vehicle') }}:</td>
        <td><b>{{ (app()->getLocale() == 'en') ? str_replace('Vozilo', 'Vehicle', $order->vehicle->name) : $order->vehicle->name }}
            </b></td>
    </tr>
    <tr>
        <td>{{ __('mail.details.start') }}:</td>
        <td><b>{{ $order->ride->address_start }}</b></td>
    </tr>
    <tr>
        <td>{{ __('mail.details.date_start') }}:</td>
        <td><b>{{ \Illuminate\Support\Carbon::make($order->ride->datetime)->format('d.m.Y. H:i') }}</b></td>
    </tr>
    <tr>
        <td>{{ __('mail.details.end') }}:</td>
        <td><b>{{ $order->ride->address_end }}</b></td>
    </tr>
    @if ($order->ride->type == 'return')
        <tr>
            <td>{{ __('mail.details.date_return') }}:</td>
            <td><b>{{ \Illuminate\Support\Carbon::make($order->ride->datetime_2)->addHour()->format('d.m.Y. H:i') }}</b></td>
        </tr>
    @endif
    <tr>
        <td>{{ __('mail.details.passangers') }}:</td>
        <td><b>{{ $order->ride->passangers }}</b></td>
    </tr>

    @if ($order->ride->start_flight != '')
        <tr>
            <td>{{ __('payment.form.flight') }}:</td>
            <td><strong>{{ ($order->ride->start_flight) ? $order->ride->start_flight : '' }}</strong></td>
        </tr>
    @endif
    @if ($order->ride->end_flight != '')
        <tr>
            <td>{{ __('payment.form.flight_end') }}:</td>
            <td><strong>{{ ($order->ride->end_flight) ? $order->ride->end_flight : '' }}</strong></td>
        </tr>
    @endif
    @if ($order->ride->info != '')
        <tr>
            <td>Info:</td>
            <td><strong>{{ ($order->ride->info) ? $order->ride->info : '' }}</strong></td>
        </tr>
    @endif

    @if ($order->ride->start_flight_2 != '')
        <tr>
            <td>{{ __('payment.form.flight_return') }}:</td>
            <td><strong>{{ ($order->ride->start_flight_2) ? $order->ride->start_flight_2 : '' }}</strong></td>
        </tr>
    @endif
    @if ($order->ride->end_flight_2 != '')
        <tr>
            <td>{{ __('payment.form.flight_return_end') }}:</td>
            <td><strong>{{ ($order->ride->end_flight_2) ? $order->ride->end_flight_2 : '' }}</strong></td>
        </tr>
    @endif
    @if ($order->ride->info_2 != '')
        <tr>
            <td>Info:</td>
            <td><strong>{{ ($order->ride->info_2) ? $order->ride->info_2 : '' }}</strong></td>
        </tr>
    @endif

</table>
