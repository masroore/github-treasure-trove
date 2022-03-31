
            <div class="hr-line-dashed"></div>


            <div class="form-group">
                <label class="col-md-2 control-label">Delivery Time</label>
                <div class="col-md-4">
                    <input type="text" name="name" value="{{ old('name', isset($deliverytime) ? $deliverytime->name : null) }}"
                        class="form-control">
                </div>
            </div>

            <div class="hr-line-dashed"></div>

            <div class="form-group">
                <label class="col-md-2 control-label">Is Enabled</label>
                <div class="col-md-4">
                    <select class="form-control m-b js-dropdown-select2" name="is_available">
                        <option value="1" @if (old('is_available', isset($deliverytime) ? $deliverytime->is_available : null) == 1) selected @endif>Yes</option>
                        <option value="0" @if (old('is_available', isset($deliverytime) ? $deliverytime->is_available : null) == 0) selected @endif>No</option>
                    </select>
                </div>
            </div>

@section('ext_js')
    <script type="text/javascript">
    $(document).ready(function(){
        
        $("#createDeliveryTimeForm").validate({
             rules: {
               name: "required"
             },
             messages : {
                name : {required : 'Required'}
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

        $("#updateDeliveryTimeForm").validate({
             rules: {
               name: "required"
             },
             messages : {
                name : {required : 'Required'}
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


    });
</script>
@endsection
