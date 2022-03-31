
<style type="text/css">
    
    .col-1-5 {
    flex: 0 0 12.3%;
    max-width: 12.3%;
    position: relative;
    width: 100%;
    padding-right: 15px;
    padding-left: 15px;
}
</style>
<div class="row">
            <?php /*<div class="col-md-6">
                <label for="option">Option Required</label>
                <select name="option_required" class="form-control">
                    <option value="1"
                    @if(isset($product->options) && $product->options->first()!=null && $product->options->first()->required ==1) selected @endif>
                    Yes</option>
                    <option value="0"
                    @if(isset($product->options) && $product->options->first()!=null && $product->options->first()->required ==0) selected @endif>
                    No</option>
                </select>
            </div>
            */?>
            <div class="col-md-6">
                <label for="option">Options</label>
                <select class="form-control js-dropdown-select2" list="options" id="options">
                    <option value="">select options</option>
                    @foreach ($options as $option)
                        <option value="{{ $option->id }}">{{ $option->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="options-panel">
            @if ($action == 'edit')
                @forelse ($product->options as $counter=>$productOption)

                    @if(isset($productOption->option))

                        @switch($productOption->option->type)
                            @case('input')


                            <div class="hpanel">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <h5><strong>{{ $productOption->option->name }}</strong> </h5>
                                        </div>

                                         <div class="col-md-2">
                                            <h5>Is Required</h5>
                                         </div>

                                        <div class="col-md-3">                
                                            <select name="option[required][{{$productOption->option->id}}]" id="option[required][{{$productOption->option->id}}]" class="form-control">
                                                <option {{(isset($productOption->required) && $productOption->required==0) ? 'selected' : ''}} value="0">No</option>
                                                <option {{(isset($productOption->required) && $productOption->required==1) ? 'selected' : ''}} value="1" >Yes</option>                                                
                                            </select>
                                        </div>

                                        <div class="col-md-4 pull-right text-right">
                                            <button class="btn btn-danger delete-hpanel"><i class="pe-7s-close-circle"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="option[input][{{ $productOption->option->id }}]" value="">
                                <?php /*<div class="panel-body">
                                    <table class="option-values-table"
                                        class="footable table table-bordered toggle-arrow-tiny default breakpoint footable-loaded"
                                        data-page-size="8" data-filter="#filter">
                                        <thead>
                                            <tr>
                                                <th class="footable-visible">Value</span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr style="display: table-row;" class="footable-even">
                                                <td class="footable-visible" colspan="5">
                                                    <input type="text" class="form-control"
                                                        name="option[input][{{ $productOption->option->id }}]"
                                                        value="{{ $productOption->optionValues->first()->input_value }}">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>*/?>
                            </div>

                            @break


                            <?php /*
                            @case('select')
                            <div class="hpanel">
                                <input type="text" class="hidden" name="option_id[{{ $counter }}]"
                                    value="{{ $option->id }}">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <h5><strong>{{ $productOption->option->name }}</strong> </h5>
                                        </div>
                                        <div class="col-md-4 pull-right text-right">
                                            <a class="btn btn-danger delete-hpanel"><i class="pe-7s-close-circle"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <table
                                        class="option-values-table footable table table-bordered toggle-arrow-tiny default breakpoint footable-loaded"
                                        data-page-size="8" data-filter="#filter">
                                        <thead>
                                            <tr>
                                                <th class="footable-visible">Value</span></th>
                                                <th class="footable-visible footable-sortable">Quantity</span></th>
                                                <th class="footable-visible footable-sortable">Subtract stock</span></th>
                                                <th class="footable-visible footable-sortable">prefix</span></th>
                                                <th class="footable-visible footable-sortable">Price</span></th>
                                                <th class="footable-sortable">Operation</span></th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody{{ $productOption->option->id }}">
                                            @foreach ($productOption->optionValues as $productOptionValue)
                                                <tr style="display: table-row;" class="footable-even">
                                                    <td class="footable-visible">
                                                    <input type="hidden" name="option[select][option_data][{{ $counter }}][]" value="{{$productOptionValue->option_id}}">

                                                        <select name="option[select][option_values][{{ $counter }}][]"
                                                            class="form-control">
                                                            @foreach ($productOption->option->optionValues ?? [] as $item)
                                                                <option value="{{ $item->id }}"
                                                                    {{ $item->id == $productOptionValue->option_value_id ? 'selected' : '' }}>
                                                                    {{ $item->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td class="footable-visible">
                                                        <input type="number" value="{{ $productOptionValue->quantity }}"
                                                            class="form-control"
                                                            name="option[select][quantity][{{ $counter }}][]"
                                                            value="{{ 's' }}" placeholder="Total Option Stock" required>
                                                    </td>
                                                    <td class="footable-visible">
                                                        <select name="option[select][subtract_from_stock][{{ $counter }}][]"
                                                            class="form-control" required>
                                                            <option value="1" @if ($productOptionValue->subtract_from_stock == 1) selected @endif>Yes</option>
                                                            <option value="0" @if ($productOptionValue->subtract_from_stock == 0) selected @endif>No</option>
                                                        </select>
                                                    </td>
                                                    <td class="footable-visible">
                                                        <select name="option[select][price_prefix][{{ $counter }}][]"
                                                            class="form-control" required>
                                                            <option value="1"
                                                                {{ $productOptionValue->price_prefix == '1' ? 'selected' : '' }}>+
                                                            </option>
                                                            <option value="0"
                                                                {{ $productOptionValue->price_prefix == '0' ? 'selected' : '' }}>-
                                                            </option>
                                                        </select>

                                                    </td>
                                                    <td class="footable-visible">
                                                        <input type="number" value="{{ $productOptionValue->price }}"
                                                            class="form-control"
                                                            name="option[select][price][{{ $counter }}][]" placeholder="Price"
                                                            required>
                                                    </td>
                                                    <td class="footable-visible footable-last-column"><a
                                                            class="remove-option-value btn btn-danger"><i
                                                                class="fa fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr style="display: table-row;" class="footable-even">
                                                <td class="footable-visible" colspan="6"></td>
                                                <td class="footable-visible footable-last-column"><a
                                                        class="btn btn-primary add-option-value"
                                                        data-option-id="{{ $productOption->option->id }}"><i class="fa fa-plus"></i></a>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            @break

*/?>

                        @endswitch
                    @endif    
                @empty
            @endforelse
            @endif
        </div>

@section('ext_js')
 <script type="text/javascript">
        $(document).ready(function() {
            var url = '{{ route('admin.products.ajax.option') }}';
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var counter = 0;
            $("#options").change(function() {

                var optionsId = $(this).val();
                $.ajax({
                    url: url,
                    type: 'post',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "counter": counter,
                        "optionId": optionsId
                    },
                    dataType: 'JSON',
                    success: function(data) {
                        $('.options-panel').append(data.html);
                        counter++;
                    }
                });
            });

            $('.hpanel').on('click', '.delete-hpanel', function() {
                $(this).parent().parent().parent().parent().remove();
            });

            $('.hpanel').on('click', '.remove-option-value', function() {
                $(this).parent().parent().remove();
            });

            $('.hpanel').on('click', '.add-option-value', function() {

                var optionUrl = '{{ route('admin.products.ajax.option.value') }}';
                var optionId = $(this).data('option-id');

                $.ajax({
                    /* the route pointing to the post function */
                    url: optionUrl,
                    type: 'post',
                    /* send the csrf-token and the input to the controller */
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "counter": counter,
                        "optionId": optionId
                    },
                    dataType: 'JSON',
                    /* remind that 'data' is the response of the AjaxController */
                    success: function(data) {
                        console.log($('#tbody'+optionId));
                        $('#tbody'+optionId).append(data.html);
                    }
                });

                return false;
            });
        });

    </script>

    <script type="text/javascript">
        var imgSrc = '{{ asset("/images/products/") }}';

        $(document).ready(function(e){
            $('#uploadImagesBtn').hide();
            var galleryIds = $('#oldGalleryId').val();

            if(galleryIds!==undefined)
            {
                $.ajax({
                url: '/admin/products/get-product-media/'+galleryIds,
                type: "GET",
                success:function(res){
                    var htmlELement = '';
                    for(var i=0;i<res['data'].length;i++)
                    {
                        htmlELement += '<tr id="'+res["data"][i]["id"]+'"style="display: table-row;" class="footable-even">'
                        htmlELement += '<td class="footable-visible"> <img src="'+imgSrc+'/'+res["data"][i]["image"]+'" alt="" style="width:100px;"></td>'
                        htmlELement += '<td class="footable-visible footable-last-column"> <button type="button" class="btn btn-danger deleteGalleryImage"><i class="fa fa-trash"></i></button></td>'
                        htmlELement += '</tr>'
                    }
                    $('#galleryBody').append(htmlELement);
                },
                });
            }





        });


        $('#addGalleryImage').on('click',function(e)
        {
            e.preventDefault();
            $('#gallery-table tbody').append("<tr id='' style='display: table-row;' class='footable-even'><td class='footable-visible footable-first-column'> <input type='file' class='form-control gallery_images_inputs' name='gallery_image[]'/> </td><td class='footable-visible'> <input type='number' class='form-control' name='gallery_image_order[]'' placeholder='Sort Order' value='1' min='1'/> </td><td class='footable-visible footable-last-column'> <button type='button' class='btn btn-danger deleteGalleryImage'><i class='fa fa-trash'></i> </button> </td></tr>");
            $('#uploadImagesBtn').show();
        });

        $(document).on('click','.deleteGalleryImage',function(e){
            e.preventDefault();
            var rowCount = $('#galleryBody tr').find('input[type="file"]').length;

            if(rowCount<=1)
            {
                $('#uploadImagesBtn').hide();
            }
            
            var id = $(this).closest('tr').attr('id');
            
            $(this).closest('tr').remove();
            if(id)
            {
                $.ajax({
                url: '/admin/products/delete-product-media/'+id,
                type: "GET",
                success:function(res){
                    console.log('success');
                },
                });
            }
        });

        $(document).on('click','.editGalleryImage',function(e)
        {
            e.preventDefault();
            var id = $(this).closest('tr').attr('id');
            if(id)
            {
                $.ajax({
                url: '/admin/products/get-single-product-media/'+id,
                type: "GET",
                success:function(res)
                {
                    $('#singleGalleryId').val(id);
                    $('#optionValueId').val(res['data']['product_option_value_id']);
                    $('#sortOrder').val(res['data']['order']);
                    $('#galleryImg').attr('src','http://'+document.location.host+'/images/products/'+res['data']['image']);
                    $('#exampleModal').modal('show');
                },
                });
            }
        });

        $('#updateSingleGallery').on('submit',function(e){
            e.preventDefault();
            var action = $(this).attr('action');
            var formData =  new FormData(this);


            $.ajax({
                url: action,
                type: "POST",
                data: formData,
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success:function(res){
                    $('#exampleModal').modal('hide');
                },

            });

        });

    

        $('#uploadImagesBtn').on('click',function(){
            var files_data = [];
            formdata = new FormData(); 



            $('.gallery_images_inputs').each(function(index, field){
               var file = field.files[0];
               formdata.append('gallery_images[]',file);
            });

            var action = "{{ route('admin.products.upload.media') }}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
                
               $.ajax({
                    url: action,
                    type: "POST",
                    data: formdata,
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend :function(){
                        $('#uploadImagesBtn').prop('disabled', true);
                        $('#uploadImagesBtn').html("<span class='spinner-border spinner-border-sm' id='uploadImagesBtn' role='status' aria-hidden='true'></span> Please Wait...");
                    },
                    success:function(res){
                        $('#uploadImagesBtn').prop('disabled',false);
                        $('#uploadImagesBtn').html("<span id='uploadImagesBtn' role='status' aria-hidden='true'></span> Upload Image");
                        $('#uploadImagesBtn').hide();
                        var oldId = $('#galleryId').val();
                        $('#galleryId').val(res['id']+','+oldId);
                        assignIdToRow(res['data'],res['id']);
                    },
            });

                event.preventDefault();
             
        });


        // $('#uploadProductMediaForm').on('submit',function(e)
        // {
        //     e.preventDefault();
        //     var action = $(this).attr('action');
        //     var formData =  new FormData(this);


        //     console.log(formData);



            // $.ajax({
            //     url: action,
            //     type: "POST",
            //     data: formData,
            //     dataType: 'JSON',
            //     contentType: false,
            //     cache: false,
            //     processData: false,
            //     beforeSend :function(){
            //         $('#uploadImagesBtn').prop('disabled', true);
            //         $('#uploadImagesBtn').html("<span class='spinner-border spinner-border-sm' id='uploadImagesBtn' role='status' aria-hidden='true'></span> Please Wait...");
            //     },
            //     success:function(res){
            //         $('#uploadImagesBtn').prop('disabled',false);
            //         $('#uploadImagesBtn').html("<span id='uploadImagesBtn' role='status' aria-hidden='true'></span> Upload Image");
            //         $('#uploadImagesBtn').hide();
            //         var oldId = $('#galleryId').val();
            //         $('#galleryId').val(res['id']+','+oldId);
            //         assignIdToRow(res['data'],res['id']);
            //     },

            // });
        // });

        function assignIdToRow(responseDataArray,responseIdArray){
            var htmlELement = '';
            var rowCount = $('#galleryBody tr').length;

            if(rowCount>0)
            {
                for(var i=0;i<(responseDataArray.length);i++)
                {

                    $("#galleryBody").find("tr:nth-child("+rowCount+")").empty();

                    htmlELement += '<td class="footable-visible"> <img src="'+imgSrc+'/'+responseDataArray[i]["image"]+'" alt="" style="width:100px;"></td>'
                    htmlELement += '<td class="footable-visible">'+responseDataArray[i]["order"]+'</td>'
                    htmlELement += '<td class="footable-visible footable-last-column"> <button type="button" class="btn btn-danger deleteGalleryImage"><i class="fa fa-trash"></i></button></td>'

                    $("#galleryBody").find("tr:nth-child("+rowCount+")").html(htmlELement);
                    $("#galleryBody").find("tr:nth-child("+rowCount+")").attr('id',responseIdArray[i]);
                    rowCount=rowCount-1;
                    htmlELement = '';
                }
            }
        }

        function showDetails(unquie_id){
            $("#group_data_info").hide();
            if(unquie_id.length=='9'){
               var selected_groupid = $("#group_"+unquie_id).val();
            } else{
                var selected_groupid = $("#"+unquie_id.id).val();
            }

            if(selected_groupid==''){
                alert('Please select group to get details');
                return false;
            }

            $.ajax({
                url: '/admin/products/get-group-details/'+selected_groupid,
                type: "GET",
                success:function(res){
                    var htmlELement = '';
                    for(var i=0;i<res['data'].length;i++)
                    {
                        htmlELement += '<tr style="display: table-row;" class="footable-even">'
                        htmlELement += '<td class="footable-visible"> '+res["data"][i]["package"]['package_name']+'</td>'
                        htmlELement += '<td class="footable-visible">'+res["data"][i]["zip_code"]+'</td>'
                        htmlELement += '<td class="footable-visible">'+res["data"][i]["deliverytime"]['name']+'</td>'
                        htmlELement += '<td class="footable-visible">'+res["data"][i]["price"]+'</td>'
                        htmlELement += '</tr>'
                    }
                    $("#group_label").html(res['data'][0]['group']['group_name']);
                    $("#group_data_info").show();
                    $("#prices_body").html('');
                    $('#group_details_table').append(htmlELement);
                },
            });
        }

        var groups = <?php echo json_encode($groups); ?>;
        var groupCount = <?php echo count($groups) - 1; ?>;
        function addRow(){
            var div_counts = $(".morediv").length;
            if(div_counts < groupCount){
                var divid = 'div_'+makeid();
                var selectid = 'select_'+makeid();

                var html = '<div class="row morediv" id="'+divid+'">';
                    html += '<br><div class="col-md-9">';
                    html += '<label class="option">Group Name</label>';                                   
                            html += '<select id="'+selectid+'" class="form-control js-dropdown-select2" type="number" name="groups[]">';
                                html +='<option value="">Select Group</option>';

                            $.each(groups, function(i, item) {
                                html +='<option value="'+groups[i].id+'">'+groups[i].group_name+'</option>';
                            });

                            html +='</select>'
                     html += '</div>';
                     html += '<div class="col-md-3"><label for="option " class="rows"></label>';
                     html +="<button type='button' class='btn btn-danger' onclick='removeRow("+divid+")'>-</button>&nbsp;";
                     html +="<button type='button' title='View Selected Group Details' class='btn btn-info' onclick='showDetails("+selectid+")'>info</button>";
                     html += '</div>';
                html += '</div>';

                $("div#other_divs:last").append(html);
                $(".js-dropdown-select2").select2();
            } 
            return false;
        }

        function removeRow(id_div){
            $("#"+id_div.id).remove();
        }

        function removeWithNum(id_div){
            $("#"+id_div).remove();
        }

        function makeid() {
          var text = "";
          var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

          for (var i = 0; i < 10; i++)
            text += possible.charAt(Math.floor(Math.random() * possible.length));

          return text;
        }

    </script>
    @endsection