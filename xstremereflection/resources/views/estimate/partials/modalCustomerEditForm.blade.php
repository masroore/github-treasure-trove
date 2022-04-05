
@csrf

<div class="form-group">
    <label for="customer">Select Customer</label>
    <select class="form-control select" id="customer" name="customer" style="width: 100%" onchange="customerChange()" >
        <option selected> Select Customer or Add New Customer </option>
        <option value="0"> Add New Customer </option>
        @foreach($customers as $customer)
            <option value="{{$customer->id}}" @if($customer->id == $estimate->customerId) selected @endif > {{$customer->lastName ?? 'Unknown Customer'}} {{$customer->firstName ?? ''}}</option>
        @endforeach
    </select>
</div>

<div id="datepicker-popup" class="input-group date datepicker">
    <input type="text" name="dateofService" class="form-control" value="{{($estimate->dateofService ? \Carbon\Carbon::parse($estimate->dateofService)->format('m-d-Y') : '')}}">
    <span class="input-group-addon input-group-append border-left">
        <span class="mdi mdi-calendar input-group-text"></span>
    </span>
</div>
<div class="form-group">
    <label for="detailType">Detail Type</label>
    <select class="form-control select" id="detailType" name="detailType" >
        <option selected> Select Type of Detail Location </option>

        <option value="1" @if($estimate->detailType == 1) selected @endif > Shop</option>
        <option value="2" @if($estimate->detailType == 2) selected @endif > Mobile</option>


    </select>
</div>

<div class="form-group">
    <label for="serviceTime">Select Time (Arrival Window is 3 Hours)</label>
    <select class="form-control" id="arrivalTime" name="arrivalTime">
        <option value="0" @if(!$estimate->arrivalTime) selected @endif > Select Time of Arrival </option>

        <option value="06:00:00" @if($estimate->arrivalTime === '06:00:00') selected @endif > 6:00 AM</option>
        <option value="07:00:00" @if($estimate->arrivalTime === '07:00:00') selected @endif > 7:00 AM</option>
        <option value="08:00:00" @if($estimate->arrivalTime === '08:00:00') selected @endif > 8:00 AM</option>
        <option value="09:00:00" @if($estimate->arrivalTime === '09:00:00') selected @endif > 9:00 AM</option>
        <option value="10:00:00" @if($estimate->arrivalTime === '10:00:00') selected @endif > 10:00 AM</option>
        <option value="11:00:00" @if($estimate->arrivalTime === '11:00:00') selected @endif > 11:00 AM</option>
        <option value="12:00:00" @if($estimate->arrivalTime === '12:00:00') selected @endif > 12:00 AM</option>
        <option value="13:00:00" @if($estimate->arrivalTime === '13:00:00') selected @endif > 1:00 PM</option>
        <option value="14:00:00" @if($estimate->arrivalTime === '14:00:00') selected @endif > 2:00 PM</option>
        <option value="15:00:00" @if($estimate->arrivalTime === '15:00:00') selected @endif > 3:00 PM</option>
        <option value="16:00:00" @if($estimate->arrivalTime === '16:00:00') selected @endif > 4:00 PM</option>
        <option value="17:00:00" @if($estimate->arrivalTime === '17:00:00') selected @endif > 5:00 PM</option>
        <option value="18:00:00" @if($estimate->arrivalTime === '18:00:00') selected @endif > 6:00 PM</option>
        <option value="19:00:00" @if($estimate->arrivalTime === '19:00:00') selected @endif > 7:00 PM</option>
        <option value="20:00:00" @if($estimate->arrivalTime === '20:00:00') selected @endif > 8:00 PM</option>
        <option value="21:00:00" @if($estimate->arrivalTime === '21:00:00') selected @endif > 9:00 PM</option>

    </select>
</div>

<div id="newCustomer">
    <div class="form-group">
        <label for="firstName">First Name</label>
        <input class="form-control" id="firstName" name="firstName" />
    </div>
    <div class="form-group">
        <label for="lastName">Last Name</label>
        <input class="form-control" id="lastName" name="lastName" />
    </div>
    <div class="form-group">
        <label for="email">Email Address</label>
        <input class="form-control" id="email" name="email" />
        <span class="text-danger" style="display: none">This email is taken</span>
    </div>
    <div class="form-group">
        <label for="address">Address</label>
        <input class="form-control" id="address" name="address" />
    </div>
    <div class="form-group">
        <label for="phone">Phone Number</label>
        <input class="form-control" id="phone" name="phoneNumber" />
    </div>
</div>

<script>
    (function($) {
        'use strict';

        if ($("#datepicker-popup").length) {
            $('#datepicker-popup').datepicker({
                todayHighlight: true,
            });
        }
        if ($("#timepicker-example").length) {
            $('#timepicker-example').datetimepicker({
                format: 'LT'
            });
        }
    })(jQuery);
</script>

<script>
    $(document).ready(function() {
        $('.selectBasic').select2();
    });
</script>
