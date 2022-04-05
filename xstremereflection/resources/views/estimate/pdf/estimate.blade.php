<html>
<head>
    <title>Customer Estimate - PDF</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        tr {
            page-break-inside: avoid
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-6">
            <img src="{{ public_path($estimate->customer->company->logo) }}" width="450px" height="140px" alt="logo" />
        </div>
        <div class="col-6">
            <address>
                 <br/>
                {{$estimate->customer->company->house ?? ''}} {{$estimate->customer->company->street ?? ''}}<br/>
                {{$estimate->customer->company->city ?? ''}} {{$estimate->customer->company->state ?? ''}} {{$estimate->customer->company->zip ?? ''}} <br />
                {{$estimate->customer->company->phone ?? ''}}
            </address>
            <h3>Estimate ID: {{$estimate->eid ?? 'Unknown ID'}}</h3>
            <h3>Estimate Date: {{\Carbon\Carbon::parse($estimate->created_at)->format('M d Y')}}</h3>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-6">
            <h3>Customer Information</h3>
            <hr>
            <div class="row">
                Customer: {{$customer->firstName ?? 'Unknown Customer'}} {{$customer->lastName ?? ''}} - @if($customer->phoneNumber) {{ '('.substr($customer->phoneNumber, 0, 3).') '.substr($customer->phoneNumber, 3, 3).'-'.substr($customer->phoneNumber,6)  }} @endif <br />
                Address: {{$customer->address ?? ''}} <br/>
                Date of Service: @if($estimate->dateofService){{\Carbon\Carbon::parse($estimate->dateofService)->format('M d Y')}} @else TBD @endif <br />
                Detail Service Type: @if($estimate->detilType == 1) Shop Detail @elseif($estimate->detailType == 2) Mobile Detail @else T.B.D @endif <br />
                Arrival Window: @if($estimate->arrivalTime){{\Carbon\Carbon::parse($estimate->arrivalTime)->format('H:i')}} to {{\Carbon\Carbon::parse($estimate->arrivalTime)->addHours(3)->format('H:i')}}@else TBD @endif <br/>
            </div>
        </div>
        <div class="col-6">
            <h3>Vehicle Information</h3>
            <hr>
            @if($estimate->vehicle)
                VIN Number: {{$estimate->vehicle->vehicleInfo->vin ?? 'VIN not provided at time of estimate.'}} <br />

                Vehicle Year: {{$estimate->vehicle->vehicleInfo->year}} <br />


                Vehicle Make: {{$estimate->vehicle->vehicleInfo->make}} <br />


                Vehicle Model/Style: {{$estimate->vehicle->vehicleInfo->model}} - {{$estimate->vehicle->vehicleInfo->style}} <br />


                Vehicle Color: {{$estimate->vehicle->vehicleInfo->colorInfo->description ?? ''}}
            @else
                No Vehicle information added.
            @endif



        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <small> <strong> Reported Problem: </strong> {!! $estimate->problem ?? '' !!} </small>
        </div>
    </div>

    <div class="row">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Package #</th>
                <th>Description</th>
                @if($estimate->ndp)
                    <td>Pricing Information</td>
                @else
                    <th>List Price</th>
                    <th>Your Price</th>
                    <th>Deposit</th>
                @endif

            </tr>
            </thead>
            <tbody>
            @if($estimate->approvedPackage)
                <tr>
                    <td>{{$estimate->approvedPackage}}</td>
                    <td width="50%">
                        <h6>{{$estimate->acceptedPackage->package->description}}</h6>


                        @if($estimate->acceptedPackage->addOnService)
                            <table class="table table-sm">
                                <tr>
                                    <th><h6>Add on Services</h6></th>
                                </tr>
                                @foreach($estimate->acceptedPackage->addOnService as $aos)
                                    <tr>
                                        <td>
                                            @if($aos->serviceId == 0) {{$aos->description ?? ''}}  @else {{$aos->service->description  }} @endif - <small>List Price: ${{$aos->service->charge ?? '0.00'}}  Charged: {{$aos->price ?? '0.00'}} </small>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        @endif
                    </td>
                    @if($estimate->ndp)
                        <td>Pricing By National Detail Pros</td>
                    @else
                        <td>${{$estimate->acceptedPackage->listPrice ?? ''}}</td>
                        <td>${{$estimate->acceptedPackage->chargedPrice ?? ''}}</td>
                        <td>${{$estimate->acceptedPackage->deposit ?? ''}}</td>
                    @endif
                </tr>
            @else
                @foreach($estimate->packages as $packages)
                    <tr @if($estimate->approvedPackage == $packages->id) class="bg-success" @endif>
                        <td>{{$loop->iteration}}</td>
                        <td width="50%">
                            <h6>{{$packages->package->description}}</h6>



                            @if($packages->addOnService)
                                <table class="table table-sm">
                                    <tr>
                                        <th><h6>Add on Services</h6></th>
                                    </tr>
                                    @foreach($packages->addOnService as $aos)
                                        <tr>
                                            <td>
                                                @if($aos->serviceId == 0) {{$aos->description ?? ''}}  @else {{$aos->service->description  }} @endif - <small>List Price: ${{$aos->service->charge ?? '0.00'}}  Charged: {{$aos->price ?? '0.00'}} </small>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            @endif
                        </td>
                        @if($estimate->ndp)
                            <td>Pricing By National Detail Pros</td>
                        @else
                            <td>${{$packages->listPrice ?? ''}}</td>
                            <td>${{$packages->chargedPrice ?? ''}}</td>
                            <td>${{$packages->deposit ?? ''}}</td>
                        @endif
                    </tr>
                @endforeach
            @endif

            </tbody>
        </table>
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <small>
                <strong>Note:</strong> This estimate is not a contract or a bill. It is our best guess at the total price to complete the work started above.
                Based upon our initial inspection or conversation, if prices change or additional parts and labor are required, we will inform you prior to
                proceeding with the work. Some estimates require security deposits at the time of accepting the estimate. Your estimate is valid for
                <strong>{{$estimate->days}} days</strong>. Please refer to our cancellation policy for more information about security deposit refunds.
            </small>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-8 mr-2">
        @if($estimate->signed) <img src="{{public_path($estimate->signature)}}" width="200px" height="100px">  @else <strong>X___________________________________________________________________________</strong> @endif
    </div>
    <div class="col-3 align-text-bottom">
        @if($estimate->signed) {{\Carbon\Carbon::parse($estimate->signed)->format('m/d/Y H:i')}}  @else  <strong>____________________________________</strong> @endif
    </div>

</div>

<div class="row">
    <div class="col-8 mr-2">
        Customer Approval
    </div>
    <div class="col-3">
        Date
    </div>
</div>

<div style="page-break-after: always; page-break-inside: avoid;"></div>

<div class="row">
    <div class="col-6">
        <small>
            <strong> do I need to do prior to the detail:</strong> Please be sure to have all personal belongings out of the vehicle prior to having it detailed.
            We respect your belongings and wish that nothing happens to them. Belongings left in the vehicle will be placed in a box for your retrieval
            after the detail is completed. If the technician has to remove large amounts of trash or belongings there is a $25.00 fee added to your estimate. <p />
            <strong>Just had your car detailed by a Pro?</strong> - Now that your professional detailer has restored your car to like new condition, learn how to keep
            it that way. Most swirls and scratches build-up over time from improper washing and drying techniques. Ask your detailer how to properly wash and dry to
            maintain your car’s exterior or ask them if they offer a maintenance program.<p/>
            <strong>Maintenance Program -</strong> If you like your car to always look like it was just detailed, then it is strongly recommend to ask your
            detailer if they offer a maintenance program. A maintenance program is the option to have your detailer wash and re-wax your vehicles on a
            regular basis to maintain both your investment and their appearance to show room new condition.<p />
            <strong>The paint on your car is thin! -</strong> Chances are you’re driving a new or newer car with a factory clearcoat finish for a paint job.
            The factory clearcoat finish on modern cars is THIN. How thin? In most cases thinner than a Post-It Note. The factory sprayed clear layer of paint
            on most new cars averages around 2 mils. That’s thinner than the average post-it note.<p />
            <strong>Why is this important? -</strong> Because if the detailer you hire uses inexpensive compounds and polishes or simply scratches your car in
            the way they wash it and dry off the water, this can ruin your car’s paint job or lead to what’s called, clearcoat failure. That’s where a car
            looks like it has a bad rash because the clear layer of paint is flaking off. Here’s the deal – clearcoat failure CANNOT be fixed. The only honest
            fix is to repaint the affected panel or repaint the entire car.<p/>
            <strong>Clearcoats are scratch sensitive -</strong> Clearcoat finishes are also easily scratched; this is called scratch-sensitive. What this
            means is although clearcoats tend to be harder than the old school lacquers and enamels used before 1980, they still scratch easily and the
            scratches or swirls are unsightly and cause your car’s paint to deteriorate faster than it would without them.<p/>
            <strong>Deeper defects -</strong> Deeper below surface paint defects, like key scratches and severe Type II Water Spots may be too deep to safely
            remove. For most cars and most people, it is better to learn to trust your detailer to make the judgment call as to which defects to let remain
            versus trying to remove 100%. Often times a thorough compounding and polishing using premium quality products will reduce the visibility of deeper
            defects to the point that they are a lot less visible. This is the preferred approach for any vehicle that is used as a daily driver.<p />
            There’s a lot more to know about car detailing than simply having a wash bucket, a wash mitt and some car wax. Read through this packet of information and discuss with the detailer that gave you this information what package he recommends for your car and why.
            Glossary of Terms used in the Detailing Industry
            <strong>Car Wash -</strong> Generic term for removing loose dirt before any other exterior process is performed. This can include a normal car
            wash, rinse less wash, waterless wash or the use of a spray detailer.<p/>
            <strong>Mechanical Decontamination -</strong> To remove above surface bonded contaminants like air-borne pollution, tree sap, overspray paint
            or industrial fallout through a mechanical means such as detailing clay.<p/>
            <strong>Chemical Decontamination -</strong> Chemical decontamination is an advanced procedure where specific chemicals are used to remove either acidic or alkaline contaminants off the surface or metal particles off and out of paint.
            1-Step Cleaner/Wax - A cleaner/wax is a product that does three steps in one step. This includes cleaning, polishing and leaving behind a layer of protection. A quality brand cleaner/wax professionally applied will do a good job of restoring a clear, shiny finish but these types of products will NOT normally remove all the swirls and scratches. It will remove some of the shallow swirls and scratches and leave the remaining swirls and scratches shiny.
            2-Step Polish & Wax - A two-step polish and wax is a more advanced procedure that will remove a majority of the shallow paint defects like swirls,
        </small>

    </div>
    <div class="col-6">
        <small>
            scratches, water spots and light oxidation and restore a much nicer looking finish overall. A two-step approach requires a person to run a polisher
            two times over the paint which requires more time. The first step is to machine polish each square inch of each panel and then carefully wipe the
            polish residue off the surface. Next the wax or paint sealant is applied by hand or machine and then it too is carefully wiped off the surface.
            All these procedures take time and add to the total cost of the detailing service.<p />
            <strong>3-Step: Compound, Polish & Wax -</strong> A three-step compound, polish and wax approach is an advanced procedure that will remove a
            majority of all below surface paint defects except very deep defects. With a three step approach, first each panel is carefully compounded to
            remove the majority of deeper defects and all the shallow defects. After each panel or section, the compound must be carefully wiped off so as
            not to re-instill scratches from the wiping-process. After the compounding step is finished, the paint is polished to maximize gloss and clarity.
            Typically, a much less aggressive pad and product are used to re-polish each square inch of each panel to remove any hazing left by the more
            aggressive compounding step while perfecting the paint for application of a wax, synthetic paint sealant or paint coating. Because the compound
            and polishing step can create a near perfect finish, the polish residue must be carefully wiped-off so as to not re-instill toweling marks that
            could show up after wax wipe-off. (careful wiping requires more time and “care” from the person doing the wiping)<p />
            <strong>Buffing Pads -</strong> The quality and type of pad used has a dramatic effect on the effectiveness of any machine buffing procedure as
            well as the end results. Quality results depend upon quality pads. You cannot get high quality results from worn out, dirty pads. <p />
            <strong>Free Spinning Orbital Polishers -</strong> Free spinning orbital polishers are very safe tools that offer very good correction and
            polishing ability and can also be used to apply one-step cleaner/waxes or finishing waxes and paint sealants. Low risk of swirls or holograms. <p />
            <strong>Rotary Buffers -</strong> Rotary buffers offer the most and fastest correction ability but can at the same time impart their own swirl
            pattern called holograms. If your detailer is using only a rotary buffer be sure to ask them what type of pad and polish they “finish out with”
            to help ensure you get a true swirl-free, hologram free finish.<p/>
            <strong>Car Waxes -</strong> Car waxes are normally considered products that contain some type of waxy substance either natural or man-made or
            a combination of to aid in spreading, wipe-off, protection and longevity. Not all products with the name “wax” on the label do in fact contain
            Carnauba wax, the most well-known ingredient used to make a car wax. Check with your detailer to find out what they use.  Premium quality car
            waxes will tend to create a warm, deep shine and when taken care of via careful washing can last up to 3 months on the average car. It’s a
            good idea to re-apply a coat of wax to maintain protection and appearance quality of the finish before all of the previously applied wax has
            completely worn off.<p/>
            <strong>Synthetic Paint Sealants -</strong> Synthetic paint sealants are replacements for a car wax and as the name implies, the protection
            ingredients are synthetic or man-made. Premium quality synthetic paint sealants will tend to last longer than traditional car waxes but should s
            till be re-applied on a regular schedule to maintain protection and appearance quality of the finish.<p/>
            <strong>Ceramic or Paint Coatings -</strong> Paint coatings, that is genuine ceramic or quartz-based will last longer and protect as good and
            in most cases better than both car waxes and synthetic paint sealants. Paint coatings take more expertise to apply and the paint surface must
            be properly prepared for application of a paint coating before the coating can be applied. Each brand of paint coating on the market today has
            its own manufacturer specific paint prep recommendations.<p/>
            <strong>Cancellation Policy-</strong> Customers are encouraged not to cancel a service date or time. It can be difficult to reschedule your service
            in a timely manner. A customers first cancellation has no penalty. Upon rescheduling customer will be asked to provide a 50% service deposit which is
            non-refundable.<p />
            <strong>Deposit Policy</strong> Consumers canceling their appoint for the first time will be refunded a deposit minus material or physical order cost.
            Detailer will provide proof of product cost or order made on customer behalf. (Most often occurs with ceramic application packages).

        </small>
    </div>
</div>

</body>
</html>
