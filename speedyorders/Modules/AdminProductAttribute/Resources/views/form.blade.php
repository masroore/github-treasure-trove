<div class="form-group {{ $errors->has('attribute_label') ? 'has-error' : '' }}">
    <label for="attribute_label" class="control-label">{{ 'Attribute Label' }}</label>
    <input placeholder="Attribute Label" class="form-control" type="text" name="attribute_label" id="attribute_label"
        value="{{ isset($attribute->attribute_label) ? $attribute->attribute_label : '' }}"> </input>

    {!! $errors->first('attribute_label', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('input_type') ? 'has-error' : '' }}">
    <label for="input_type" class="control-label">{{ 'Type' }}</label>

    <select class="form-control js-dropdown-select2" name="input_type" id="input_type">
        <option value="">Select Attribute Type</option>
        <option value="1" {{ isset($attribute) && $attribute->input_type == '1' ? 'selected' : '' }}>Multiple Selection
        </option>
        <option value="0" {{ isset($attribute) && $attribute->input_type == '0' ? 'selected' : '' }}>Single Selection
        </option>
    </select>
    {!! $errors->first('input_type', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('is_required') ? 'has-error' : '' }}">
    <label for="is_required" class="control-label">{{ 'Is Required' }}</label>

    <select class="form-control js-dropdown-select2" name="is_required">
        <option value="0" {{ isset($attribute) && $attribute->is_required == '0' ? 'selected' : '' }}>No
        </option>
        <option value="1" {{ isset($attribute) && $attribute->is_required == '1' ? 'selected' : '' }}>Yes
        </option>
    </select>
    {!! $errors->first('is_required', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('attribute_code') ? 'has-error' : '' }}">
    <label for="attribute_code" class="control-label">{{ 'Attribute Code' }}</label>
    <input placeholder="Attribute Code" class="form-control" type="text" name="attribute_code" id="attribute_code"
        value="{{ isset($attribute->attribute_code) ? $attribute->attribute_code : '' }}"> </input>

    {!! $errors->first('attribute_code', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('include_in_filter') ? 'has-error' : '' }}">
    <label for="include_in_filter" class="control-label">{{ 'Use In Filter Options' }}</label>

    <select class="form-control js-dropdown-select2" name="include_in_filter">
        <option value="1" {{ isset($attribute) && $attribute->include_in_filter == '1' ? 'selected' : '' }}>Yes
        </option>
        <option value="0" {{ isset($attribute) && $attribute->include_in_filter == '0' ? 'selected' : '' }}>No
        </option>
    </select>
    {!! $errors->first('include_in_filter', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <h4>Attribute Values</h4>
    <table id="attribute-values-table" class="footable table table-stripped table-bordered toggle-arrow-tiny default breakpoint footable-loaded" data-page-size="8" data-filter="#filter">
        <thead>
            <tr>
                <th class="footable-visible">Name</span></th>
                <th class="footable-sortable">Operation</span></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($attribute->attributeValues ??[] as $key=>$item)
            <tr id style='display: table-row;' class='footable-even'>
                <td class='footable-visible footable-first-column'>
                    <input type='input' class='form-control' name='attribute_value[name][{{$key}}]' placeholder='name' id='attribute_value[name]["{{$key}}"]' value="{{$item->name}}" required/>
                </td>
                <td class='footable-visible footable-last-column'><button type='button' class='btn btn-danger delete-attribute-value'><i class='fa fa-trash'></i></button>
                </td>
            </tr>
            @empty

            @endforelse
        </tbody>
        <tfoot>
            <tr style="display: table-row;" class="footable-even">
                <td class="footable-visible footable-first-column"></td>
                <td class="footable-visible footable-last-column"><button type="button" id="add-attribute-value" class="btn btn-primary"><i class="fa fa-plus"></i></button></td>
            </tr>
        </tfoot>
    </table>
</div>
<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>

@section('ext_js')
<script type="text/javascript">
    $(document).ready(function(){
        
        $("#createProductAttributesFrm").validate({
             rules: {
               attribute_label: "required",
               input_type: "required",
               attribute_code: "required",
             },
             messages : {
                attribute_label : {required : 'Required'},
                input_type : {required : 'Required'},
                attribute_code : {required : 'Required'}
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

        /*$("#updateProductAttributesFrm").validate({
             rules: {
               package_length: "required",
               package_height: "required",
               package_width: "required",
               package_name: "required",
             },
             messages : {
                package_length : {required : 'Required'},
                package_height : {required : 'Required'},
                package_width : {required : 'Required'},
                package_name : {required : 'Required'}
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
           });*/

            var counter = {{(isset($counter) && $counter!='') ? $counter : 0}};
            $('#add-attribute-value').on('click',function(){

                $("#attribute-values-table tbody").last().append("<tr id style='display: table-row;' class='footable-even'><td class='footable-visible footable-first-column'><input type='input' class='form-control' name='attribute_value[name]["+counter+"]' placeholder='Attribute Value' id='attribute_value[name]["+counter+"]' required/></td><td class='footable-visible footable-last-column'><button type='button' class='btn btn-danger delete-attribute-value'><i class='fa fa-trash'></i></button></td></tr>");
                counter++;
            });


            $('#attribute-values-table').on('click', '.delete-attribute-value', function() {
                $(this).parents('tr').remove();
            });


    });
</script>
@endsection