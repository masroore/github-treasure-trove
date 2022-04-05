<div class="col-xl-4">
    <h2>Interior Services</h2>
    <div class="card full-height">
        <div class="card-body py-0 px-0 px-sm-3">
            <div class="list-wrapper">
                <ul class="list-group list-unstyled">

                    <li>
                        <div class="col-xl-2 text-center">

                        </div>
                        <div class="col-xl-10 text-center">
                            <strong>Service To Be Completed</strong>
                        </div>

                    </li>
                    @if($workOrder->services)
                        @foreach($workOrder->services as $s)
                            @if($s->service->serviceTypeId == 1)
                            <li class="list-group-item">
                                <div class="col-xl-2 text-center">
                                    <div class="custom-control custom-checkbox">

                                        <input type="checkbox" name="service" value="{{$s->id}}" class="form-check-input" data-id="{{$s->id}}"  @if($s->status == 2) checked @endif>

                                    </div>
                                </div>
                                <div class="col-xl-9">
                                   @if($s->service->id == 39) {{$s->description}}   @else {{$s->status}} {{$s->service->description ?? 'Unknown Service'}} @endif
                                </div>

                            </li>

                            @endif
                        @endforeach

                    @else
                        <li>
                            <div class="col-xl-2 text-center">
                                No services added to estimate
                            </div>

                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="col-xl-4">
    <h2>Exterior Services</h2>
    <div class="card full-height">
        <div class="card-body py-0 px-0 px-sm-3">
            <div class="list-wrapper">
                <ul class="list-group list-unstyled">

                    <li>
                        <div class="col-xl-2 text-center">

                        </div>
                        <div class="col-xl-10 text-center">
                            <strong>Service To Be Completed</strong>
                        </div>

                    </li>
                    @if($workOrder->services)
                        @foreach($workOrder->services as $s)
                            @if($s->service->serviceTypeId == 2)
                                <li class="list-group-item">
                                    <div class="col-xl-2 text-center">
                                    <div class="custom-control custom-checkbox">

                                        <input type="checkbox" name="service" value="{{$s->id}}" class="form-check-input" data-id="{{$s->id}}"  @if($s->status == 2) checked @endif>

                                    </div>
            </div>
                                    <div class="col-xl-10">
                                        @if($s->service->id == 39) {{$s->description}}   @else {{$s->service->description ?? 'Unknown Service'}} @endif
                                    </div>

                                </li>

                            @endif
                        @endforeach

                    @else
                        <li>
                            <div class="col-xl-2 text-center">
                                No services added to estimate
                            </div>

                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="col-xl-4">
    <h2>Other Services</h2>
    <div class="card full-height">
        <div class="card-body py-0 px-0 px-sm-3">
            <div class="list-wrapper">
                <ul class="list-group list-unstyled">

                    <li>
                        <div class="col-xl-2 text-center">

                        </div>
                        <div class="col-xl-10 text-center">
                            <strong>Service To Be Completed</strong>
                        </div>

                    </li>
                    @if($workOrder->services)
                        @foreach($workOrder->services as $s)
                            @if($s->service->serviceTypeId == 0)
                                <li class="list-group-item">
                                    <div class="col-xl-2 text-center">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="service" value="{{$s->id}}" class="custom-control-input" data-id="{{$s->id}}" @if($s->status == 2) checked @endif >

                                        </div>
                                    </div>
                                    <div class="col-xl-10">
                                        @if($s->service->id == 39) {{$s->description}}   @else {{$s->service->description ?? 'Unknown Service'}} @endif
                                    </div>

                                </li>

                            @endif
                        @endforeach

                    @else
                        <li>
                            <div class="col-xl-2 text-center">
                                No Other Services Added to Workorder
                            </div>

                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
