
<div class="row">
    <a class="btn btn-light btn-lg btn-block mb-3" href="/estimate/{{$estimate->id}}/show">View The Estimate</a>
    @if($estimate->approvedPackage && !$estimate->workorder) <a class="btn btn-outline-success btn-lg btn-block mb-3" href="/estimate/workOrder/{{$estimate->id}}">Create Work Order</a> @endif
    @if($estimate->customer->email)
        <a type="button" href="/estimate/reschedulemail/{{$estimate->id}}" class="btn btn-primary btn-lg btn-block mb-3">Send Reminder Email</a>
    @endif
    <a class="btn btn-danger btn-lg btn-block mb-3" href="/estimate/cancel/{{$estimate->id}}">Canceled By Customer</a>
    <a type="button" class="btn btn-success btn-lg btn-block mb-3" onclick="showForm()">Enter New Date</a>
</div>

<form id="newDateForm" action="estimate/updatedate/{{$estimate->id}}" method="POST">
    @csrf
    <div id="datepicker-popup-1" class="input-group date datepicker">
        <input type="text" name="dateofService" class="form-control">
        <span class="input-group-addon input-group-append border-left">
        <span class="mdi mdi-calendar input-group-text"></span>
    </span>
    </div>

    <div class="form-group">
        <label for="serviceTime">Select Time (Arrival Window is 3 Hours)</label>
        <select class="js-example-basic-single" id="arrivalTime" name="arrivalTime" style="width: 100%"  >
            <option selected> Select Time of Arrival </option>

            <option value="06:00:00"> 6:00 AM</option>
            <option value="07:00:00"> 7:00 AM</option>
            <option value="08:00:00"> 8:00 AM</option>
            <option value="09:00:00"> 9:00 AM</option>
            <option value="10:00:00"> 10:00 AM</option>
            <option value="11:00:00"> 11:00 AM</option>
            <option value="12:00:00"> 12:00 AM</option>
            <option value="13:00:00"> 1:00 PM</option>
            <option value="14:00:00"> 2:00 PM</option>
            <option value="15:00:00"> 3:00 PM</option>
            <option value="16:00:00"> 4:00 PM</option>
            <option value="17:00:00"> 5:00 PM</option>
            <option value="18:00:00"> 6:00 PM</option>
            <option value="19:00:00"> 7:00 PM</option>
            <option value="20:00:00"> 8:00 PM</option>
            <option value="21:00:00"> 9:00 PM</option>

        </select>
    </div>

    <button type="submit" class="btn btn-success">Change Date</button>
</form>


