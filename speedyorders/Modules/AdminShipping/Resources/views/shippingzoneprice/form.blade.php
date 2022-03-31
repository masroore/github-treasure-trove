
     

            @if(!empty($zoneprice))
                <input type="hidden" name="type" value="1" id="type">
            @else
                <div class="form-group">
                    <label class="col-md-2 control-label">Zone Price Type</label>
                    <div class="col-md-4">
                        <select class="form-control m-b js-dropdown-select2" name="type" id="type">
                            <option value="1" @if (old('type', isset($zoneprice) ? $zoneprice->type : null) == '1') selected @endif>Manual</option>
                            <option value="2" @if (old('type', isset($zoneprice) ? $zoneprice->type : null) == '2') selected @endif>Upload Via File</option>                        
                        </select>
                        {!! $errors->first('type', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
            @endif
            

            <div class="hr-line-dashed"></div>

            <div id="manual_div" class="section_div">

                <div class="form-group" id="err_cls" style="display: none;">
                    <label class="error" id="exists_error"></label>
                </div>

                <div class="form-group">
                    <label class="col-md-1 control-label">Group Name</label>
                    <div class="col-md-3">
                        <input type="text" name="group_name" @if($form=='edit') disabled="true" @endif id="group_name" placeholder="Enter Group Name" value="{{ old('group_name', isset($zoneprice->group) ? $zoneprice->group->group_name : null) }}"
                            class="form-control">
                    </div>
                    
                    <label class="col-md-1 control-label">Zip Code</label>
                    <div class="col-md-3">
                        @if($form=='edit')
                            <input type="text" id="zip_code"  disabled="true"  name="zip_code" placeholder="Enter Zip Code" class="form-control" value="{{ old('zip_code', isset($zoneprice->zip_code) ? $zoneprice->zip_code : null) }}">
                        @else
                            <textarea id="zip_code" name="zip_code" placeholder="Enter Zip Code (if want to enter multiple zipcode use
comma to separate zip codes)" class="form-control">{{ old('zip_code', isset($zoneprice->zip_code) ? $zoneprice->zip_code : null) }}</textarea>
                        @endif
                    </div>        
                   
                    <label class="col-md-1 control-label">Package</label>
                    <div class="col-md-3">
                        <select class="form-control js-dropdown-select2"  @if($form=='edit') disabled="true" @endif type="number" name="shipping_packages_id" id="shipping_packages_id">
                            <option value="">Select Package</option>
                            @foreach ($packages as $package)
                                <option value="{{ $package->id }}" {{ (isset($zoneprice->shipping_packages_id) && $zoneprice->shipping_packages_id == $package->id) ? 'selected' : ''}}>{{ $package->package_name }}</option>
                            @endforeach
                        </select>
                    </div> 


                </div>

                @if($form=='add')
                    <label class="error">Please select unique delivery time in each row for correct entries</label>
                    <hr>
                @endif
                <div class="form-group" id="delivery_div">



                    <label class="col-md-1 control-label">Delivery Time</label>
                    <div class="col-md-3">
                        @if(isset($form) && $form=='edit')
                            <select @if($form=='edit') disabled="true" @endif class="form-control js-dropdown-select2" type="number" name="shipping_delivery_times_id" id="shipping_delivery_times_id" required>
                                <option value="">Select Delivery Time</option>
                                @foreach ($deliverytimes as $deliverytime)
                                    <option value="{{ $deliverytime->id }}" {{ (isset($zoneprice->shipping_delivery_times_id) && $zoneprice->shipping_delivery_times_id == $deliverytime->id) ? 'selected' : ''}}>{{ $deliverytime->name }}</option>
                                @endforeach
                            </select>
                        @else
                            <select class="form-control js-dropdown-select2" type="number" name="shipping_delivery_times_id[]" id="shipping_delivery_times_id" required>
                                <option value="">Select Delivery Time</option>
                                @foreach ($deliverytimes as $deliverytime)
                                    <option value="{{ $deliverytime->id }}" {{ (isset($zoneprice->shipping_delivery_times_id) && $zoneprice->shipping_delivery_times_id == $deliverytime->id) ? 'selected' : ''}}>{{ $deliverytime->name }}</option>
                                @endforeach
                            </select>
                        @endif    
                    </div>

                    <label class="col-md-1 control-label">Price</label>
                    <div class="col-md-3 err">
                        @if(isset($form) && $form=='edit')
                            <input type="text" name="price" required placeholder="Price" value="{{$zoneprice->price}}" class="form-control">
                        @else
                            <input type="text" name="price[]" required placeholder="Price" value="" class="form-control">
                        @endif
                        
                    </div>

                    @if($form=='add')
                        <button type="button" class="btn btn-success" onclick="addRow()">+</button>
                    @endif

                </div>

                <div id="other_divs">
                </div>
                
            </div>

            <div id="file_upload_div" class="section_div" style="display: none;">
                <label>Upload Via File Zone</label>

                <div class="form-group">
                    <label class="col-md-2 control-label">Upload File Download</label>
                    <div class="col-md-4">
                        <input type="file" name="file_name" class="form-control">
                    </div>
                
                    <label class="col-md-2 control-label">
                    {!! Html::link('zone_prices.csv', 'Sample File Download') !!}</label>
                    
                </div>

            </div>
<style type="text/css">
 
div.section_div {
    border: 1px solid gray;
    padding: 18px;
    border-radius: 5px;
}
</style>
@section('ext_js')
<script type="text/javascript">
var deliveryTimes = <?php echo json_encode($deliverytimes); ?>;

var deliveryTimesCount = <?php echo count($deliverytimes) - 1; ?>;


function addRow(){
    var div_counts = $(".morediv").length;
    if(div_counts < deliveryTimesCount){
        var divid = 'div_'+makeid();
        var selectid = 'select_'+makeid();
        var priceid = 'price_'+makeid();

        var html = '<div class="form-group morediv" id="'+divid+'">';

            html += '<label class="col-md-1 control-label">Delivery Time</label>';
            html += '<div class="col-md-3">';                        
                            html += '<select id="'+selectid+'" class="form-control js-dropdown-select2" type="number" name="shipping_delivery_times_id[]" required>';
                                html +='<option value="">Select Delivery Time</option>';

                            $.each(deliveryTimes, function(i, item) {
                                html +='<option value="'+deliveryTimes[i].id+'">'+deliveryTimes[i].name+'</option>';
                            });

                            html +='</select>'
            html += '</div>';

            html += '<label class="col-md-1 control-label">Price</label>';
            html += '<div class="col-md-3 err">';
                html += '<input type="text" name="price[]" id="'+priceid+'" value="" placeholder="Price" class="form-control" required>';
            html += '</div>';

            html +="<button type='button' class='btn btn-danger' onclick='removeRow("+divid+")'>-</button>";

        html += '</div>';

        $("div#other_divs:last").append(html);
        $(".js-dropdown-select2").select2();
    } 
    return false;

}

function removeRow(id_div){
    $("#"+id_div.id).remove();
}

$(document).ready(function(){

    $("#createzonepriceForm").validate({
        rules: {
           group_name: "required",
           zip_code: "required",
           shipping_packages_id: "required",
           'shipping_delivery_times_id' : "required",
           'price' :  "required",
           file_name : {
            required: true,
            extension: "csv"
           },
        },
        messages : {
            group_name : {required : 'Required'},
            zip_code : {required : 'Required'},
            shipping_packages_id : {required : 'Required'},
            'shipping_delivery_times_id' : {required : 'Required'},
            'price' : {required : 'Required'},            
            file_name : {
                required : 'Required',
                extension : 'Select only .csv file'
            },
        },
        highlight: function (element, errorClass, validClass) {
           var elem = $(element);
           if (elem.hasClass("select2-hidden-accessible")) {
               $("#select2-" + elem.attr("id") + "-container").parent().addClass(errorClass); 
           } else {
               elem.addClass(errorClass);
           }
        },    
        unhighlight: function (element, errorClass, validClass) {
             var elem = $(element);
             if (elem.hasClass("select2-hidden-accessible")) {
                  $("#select2-" + elem.attr("id") + "-container").parent().removeClass(errorClass);
             } else {
                 elem.removeClass(errorClass);
             }
        },
        errorPlacement: function(error, element) {
           var elem = $(element);
           if (elem.hasClass("select2-hidden-accessible")) {
               element = $("#select2-" + elem.attr("id") + "-container").parent(); 
               error.insertAfter(element);
           } else {
               error.insertAfter(element);
           }
        }
    });

    $("#updatezonepriceForm").validate({
        rules: {
           group_name: "required",
           zip_code: "required",
           shipping_packages_id: "required",
           shipping_delivery_times_id: "required",
           price: {
                "required" : true
            },
           file_name : {
            required: true,
            extension: "csv"
            },
        },
        messages : {
            group_name : {required : 'Required'},
            zip_code : {required : 'Required'},
            shipping_packages_id : {required : 'Required'},
            shipping_delivery_times_id : {required : 'Required'},
            price : {
                required : 'Required'
            },
            file_name : {
                required : 'Required',
                extension : 'Select only .csv file'
            },
        },
        highlight: function (element, errorClass, validClass) {
           var elem = $(element);
           if (elem.hasClass("select2-hidden-accessible")) {
               $("#select2-" + elem.attr("id") + "-container").parent().addClass(errorClass); 
           } else {
               elem.addClass(errorClass);
           }
        },    
        unhighlight: function (element, errorClass, validClass) {
             var elem = $(element);
             if (elem.hasClass("select2-hidden-accessible")) {
                  $("#select2-" + elem.attr("id") + "-container").parent().removeClass(errorClass);
             } else {
                 elem.removeClass(errorClass);
             }
        },
        errorPlacement: function(error, element) {
           var elem = $(element);
           if (elem.hasClass("select2-hidden-accessible")) {
               element = $("#select2-" + elem.attr("id") + "-container").parent(); 
               error.insertAfter(element);
           } else {
               error.insertAfter(element);
           }
        },
        submitHandler: function(form) {


            checkPriceExists(form);
            return false;
        },
    });
});

/*function checkPriceExists(form){
    $.ajax(
    {
        headers: {
          
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        type: "POST",
        dataType: 'JSON',
        url: '{{route("validateprice")}}',
        data: {'group_name' : $("#group_name").val(),'zip_code' : $("#zip_code").val(),'shipping_delivery_times_id' : $("#shipping_delivery_times_id").val(), 'zoneprice_id': $("#zoneprice_id").val()},
        success: function(data)
        {
            if(data){
                $("#err_cls").show();
                $("#exists_error").text("Price already added for selected Group/Zipcode/Delivery Time combination");
                $("#exists_error").show();
                return false;
            } else {
                $("#err_cls").hide();
                $("#exists_error").hide();
                $("#exists_error").text("");

                form.submit();

                return true;
            }
        }
    });
}*/


function makeid() {
  var text = "";
  var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

  for (var i = 0; i < 10; i++)
    text += possible.charAt(Math.floor(Math.random() * possible.length));

  return text;
}


$("#type").change(function(){
    $("#manual_div").hide();
    $("#file_upload_div").hide();
    
    if(this.value==2){
        $("#file_upload_div").show();
    } 

    if(this.value==1){
        $("#manual_div").show();
    } 
});
</script>
@endsection


