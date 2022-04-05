   <script>
   $(document).ready(function () {
    var baseUrl = $('#app_base_url').val();

       var i = 2;
       $("#select_product").hide();
       $("#combo_sell_Price_div").hide();
       $("#combo_selling_price").attr('disabled', true);
       $("#select_product").attr('disabled', true);
       $('.summernote').summernote({
           height: 200
           });
       $(".selected_variant").unbind().change(function () {
           $(".add_items_button").show();
           let variant = $(this).val();
           var head = "<tr>";
           var row_list = "";

           $.each(variant, function (key, value) {
               $.ajax({
                   url: "{{url('/')}}"+ "/product/variant_with_values/" + value,
                   type: "GET",
                   async: false,
                   success: function (response) {
                       head += "<th scope=\"col\">" + response.name + "</th>";
                       row_list += "<td>";
                       row_list += `<input name='variation_type[]'  hidden value="${response.id}">`;
                       row_list += "<select class='primary_select mb-15' name='variation_value_id[]'>";
                       $.each(response.values, function (i_key, i_value) {
                           row_list += `<option value="${i_value.id}">${i_value.value}</option>`;
                       });
                       row_list += "</select>";
                       row_list += "</td>";
                   }
               });
           });
           head += `<th scope="col">SKU</th>
                   <th scope="col">Alert Qty</th>
                   <th scope="col">Purchase Price</th>
                   <th scope="col">Min. Selling Price</th>
                   <th scope="col">Selling Price</th>
                   <th scope="col">Product Images</th>`;
           head += "</tr>";
           row_list += `<td>
                           <input name='variation_sku[]' type="text" class="primary_input_field"/>
                        </td>
                        <td>
                           <input type="number" min="0" step="1" class="primary_input_field" name='alert_quantities[]'/>
                        </td>
                        <td>
                           <input type="number" min="0" step="0.01" class="primary_input_field" name='purchase_prices[]'/>
                        </td>
                        <td>
                           <input type="number" min="0" step="0.01" class="primary_input_field" name='min_selling_prices[]'/>
                        </td>
                        <td>
                           <input type="number" min="0" step="0.01" class="primary_input_field" name='selling_prices[]'/>
                        </td>
                        <td>
                           <div class="primary_file_uploader">
                              <input class="primary-input" type="text" id="placeholderFileOneName" placeholder="Browse file" readonly="">
                              <button class="" type="button">
                              <label class="primary-btn small fix-gr-bg" for="document_file_2">Browse</label>
                              <input type="file" class="d-none" name="variation_file[]" id="document_file_2">
                              </button>
                           </div>
                        </td>`;
           $("#variant_section_head").html(head);
           $(".variant_row_lists").html(row_list);
           $('select').niceSelect();
       });

       $(".product_type").unbind().change(function () {
           let type = $(this).val();
           console.log(type);
           if (type === "Variable") {
               $(".choose_variant").show();
               $("#unit_type_div").show();
               $("#tax_div").show();
               $("#tax_type_div").show();
               $("#brand_div").show();
               $("#category_div").show();
               $("#model_div").show();
               $("#sub_category_div").show();
               $("#product_sku_div").hide();
               $("#select_product").hide();
               $("#stock_quantity_div").hide();
               $("#alert_quantity_div").hide();
               $("#combo_sell_Price_div").hide();
               $("#showroom_div").show();
               $("#combo_sell_Price_div").attr('disabled', true);
               $("#product_sku").attr('disabled', true);
               $("#stock_quantity").attr('disabled', true);
               $("#alert_quantity").attr('disabled', true);
               $("#purchase_price").attr('disabled', true);
               $("#selling_price").attr('disabled', true);
               $("#min_selling_price").attr('disabled', true);
               $('#purchase_price').removeAttr('readonly');
               $('#selling_price').removeAttr('readonly');
               $('#purchase_price_div').hide();
               $('#selling_price_div').hide();
               $('#min_selling_price_div').hide();
               $("#other_currency_price").show();
           }
           else if (type === "Combo") {
               $(".choose_variant").hide();
               $("#tax_div").hide();
               $("#showroom_div").hide();
               $("#tax_type_div").hide();
               $("#select_product").show();
               $("#product_sku_div").hide();
               $("#product_sku").attr('disabled', true);
               $("#unit_type_div").hide();
               $("#brand_div").hide();
               $("#category_div").hide();
               $("#sub_category_div").hide();
               $("#model_div").hide();
               $("#stock_quantity_div").hide();
               $("#alert_quantity_div").hide();
               $("#combo_sell_Price_div").hide();
               $("#combo_sell_Price_div").show();
               $("#other_currency_price").hide();
               $("#combo_sell_Price_div").removeAttr("disabled");
               $('#purchase_price').attr('readonly', true);
               $('#selling_price').attr('readonly', true);
               $('#purchase_price_div').show();
               $('#selling_price_div').show();
               $("#purchase_price").removeAttr("disabled");
               $("#selling_price").removeAttr("disabled");
               $("#stock_quantity").attr('disabled', true);
               $("#combo_selling_price").removeAttr("disabled");
               $("#alert_quantity").attr('disabled', true);
           } else {
               $("#showroom_div").show();
               $(".choose_variant").hide();
               $("#select_product").hide();
               $("#tax_div").show();
               $("#tax_type_div").show();
               $("#unit_type_div").show();
               $("#model_div").show();
               $("#brand_div").show();
               $("#category_div").show();
               $("#sub_category_div").show();
               $("#product_sku_div").show();
               $('#purchase_price_div').show();
               $('#selling_price_div').show();
               $('#min_selling_price_div').show();
               $("#stock_quantity_div").show();
               $("#alert_quantity_div").show();
               $("#product_sku").removeAttr("disabled");
               $("#stock_quantity").removeAttr("disabled");
               $("#alert_quantity").removeAttr("disabled");
               $("#purchase_price").removeAttr("disabled");
               $("#selling_price").removeAttr("disabled");
               $("#min_selling_price").removeAttr("disabled");
               $('#purchase_price').removeAttr('readonly');
               $('#selling_price').removeAttr('readonly');
               $('#min_selling_price').removeAttr('readonly');
               $("#combo_sell_Price_div").hide();
               $("#combo_sell_Price_div").attr('disabled', true);
               $("#other_currency_price").show();
           }
       });

       $(".as_sub_category").unbind().click(function () {
           $(".parent_category").toggle();
       });


       function getCategory(){
          $.ajax({
              url: "{{route("category.all")}}",
              type: "GET",
              success: function (response) {

                  $.each(response, function (key, item) {
                       $(".category").append(`<option value="${item.id}">${item.name}</option>`);
                   });
                  $('select').niceSelect('update');
              },
              error: function (error) {
                 console.log(error)
              }

          });
       }

       $("#categoryForm").on("submit", function (event) {
           event.preventDefault();
           let formData = $(this).serializeArray();
           $.each(formData, function (key, message) {
               $("#" + formData[key].name + "_error").html("");
           });
           $.ajax({
               url: "{{route("category.store")}}",
               data: formData,
               type: "POST",
               success: function (response) {
                   $("#Item_Details").modal("hide");
                   $("#categoryForm").trigger("reset");
                   $(".parent_category").hide();
                   $('.category').html('')

                   getCategory();
               },
               error: function (error) {
                   if (error) {
                       $.each(error.responseJSON.errors, function (key, message) {
                           $("#" + key + "_error").html(message[0]);
                       });
                   }
               }

           });
       });

       $(".note-codable").attr("name", "description");
       $(document).on('click', '.remove_variant_row', function () {
           $(this).parents('.variant_row_lists').fadeOut();
           $(this).parents('.variant_row_lists').remove();
       });

       $(document).on("click", '.add_variant_row', function () {
           let variant = $(".selected_variant").val();
           var row_list = "";
           i++;
           row_list += "<tr class='variant_row_lists'>";
           $.each(variant, function (key, value) {
               $.ajax({
                   url: baseUrl + "/product/variant_with_values/" + value,
                   type: "GET",
                   async: false,
                   success: function (response) {
                       row_list += "<td>";
                       row_list += `<input name='variation_type[]' hidden value="${response.id}">`;
                       row_list += "<select class='primary_select mb-15' name='variation_value_id[]'>";
                       $.each(response.values, function (i_key, i_value) {
                           row_list += `<option value="${i_value.id}">${i_value.value}</option>`;
                       });
                       row_list += "</select>";
                       row_list += "</td>";
                   }
               });
           });

           row_list += '<td>'+
                            '<input name="variation_sku[]" type="text" class="primary_input_field"/>'+
                          '</td>'+
                           '<td>'+
                               '<input type="number" min="0" step="1" class="primary_input_field" name="alert_quantities[]"/>'+
                           '</td>'+
                            '<td>'+
                                '<input type="number" min="0" step="0.01" class="primary_input_field" name="purchase_prices[]"/>'+
                            '</td>'+
                            '<td>'+
                                '<input type="number" min="0" step="0.01" class="primary_input_field" name="min_selling_prices[]"/>'+
                            '</td>'+
                            '<td>'+
                                '<input type="number" min="0" step="0.01" class="primary_input_field" name="selling_prices[]"/>'+
                            '</td>'+
                           '<td>'+
                               '<div class="primary_file_uploader">'+
                                   '<input class="primary-input" type="text" id="placeholderFileOneName" placeholder="Browse file" readonly="">'+
                                   '<button class="" type="button">'+
                                       '<label class="primary-btn small fix-gr-bg" for="document_file_'+i+'">Browse</label>'+
                                       '<input type="file" class="d-none" name="variation_file[]" id="document_file_'+i+'">'+
                                   '</button>'+
                               '</div>'+
                           '</td>'+
                            '<td class="pl-0 pb-0 pr-0 remove_variant_row" style="border:0">'+
                              '<div class="items_min_icon "><i class="fas fa-minus-circle"></i></div>'+
                            '</td>';
           row_list += "<tr>";

           $(".variant_row_lists:last").after(row_list);
           $('select').niceSelect();
       });

       $(".manage_stock").click(function () {
           $("#alert_quantity").toggle();
       });
       $("#sub_category_list").addClass("primary_select");

       $(".category").unbind().change(function () {
           let category = $(this).val();
           $.ajax({
               url: baseUrl + "/product/category_wise_subcategory/" + category,
               type: "GET",
               success: function (response) {
                   $("#sub_category_list").addClass("primary_select");
                   $.each(response, function (key, item) {
                       $("#sub_category_list").append(`<option value="${item.id}">${item.name}</option>`);
                   });
               },
               error: function (error) {
                   console.log(error)
               }
           });
       });

       $("#selected_product_id").unbind().change(function () {
            var i = 0;
            let sku_id = $(this).val();
            var purchase_price = $("#purchase_price").val();
            var selling_price = $("#selling_price").val();
            $.post('{{ route('product_sku.get_product_price') }}', {_token:'{{ csrf_token() }}', sku_id:sku_id, purchase_price:purchase_price, selling_price:selling_price}, function(data){
               // console.log(sku_id);
               $.each(data.name, function(index, value){
                   $('.row_id_'+index).remove();
                   $( ".form" ).append('<div class="col-lg-4 row_id_'+index+'">'+
                       '<div class="primary_input mb-15">'+
                           '<div class="primary_input mb-15">'+
                               '<input class="primary_input_field" readonly id="selected_product_name_'+index+'" placeholder="Name" type="text" value="'+value.sku+'">'+
                           '</div>'+
                       '</div>'+
                   '</div>'+
                   '<div class="col-lg-4 row_id_'+index+'">'+
                       '<div class="primary_input mb-15">'+
                           '<input class="primary_input_field" name="selected_product_qty[]" placeholder="Quantity" type="number" min="0" onkeyup="calculatePrice()" step="1" value="1">'+
                       '</div>'+
                   '</div>'+
                   '<div class="col-lg-3 row_id_'+index+'">'+
                       '<div class="primary_input mb-15">'+
                           '<input class="primary_input_field" name="selected_product_price[]" placeholder="Price" type="number" min="0" step="0.01" value="'+value.selling_price+'">'+
                       '</div>'+
                   '</div>'+
                   '<div class="col-lg-1 row_id_'+index+'">'+
                       '<div class="primary_input mb-15">'+
                           '<input class="primary_input_field" name="selected_product_tax[]" placeholder="Quantity" type="number" min="0" step="0.01" value="'+value.tax+'">'+
                       '</div>'+
                   '</div>'+
                   '</div>' );
               });
               $("#purchase_price").val(data.newpurchasePrice);
               $("#selling_price").val(data.newsellPrice);
            });

           $('select').niceSelect();
       });

   });
   function calculatePrice(){
       var qtys = $("input[name='selected_product_qty[]']").map(function(){return $(this).val();}).get();
       var prices = $("input[name='selected_product_price[]']").map(function(){return $(this).val();}).get();
       var tax = $("input[name='selected_product_tax[]']").map(function(){return $(this).val();}).get();
       var sum = 0;
       for (var i = 0; i < qtys.length; i++) {
           sum = parseInt(sum) + parseInt(qtys[i]) * (parseInt(prices[i]) + (parseInt(prices[i]) * parseInt(tax[i]) / 100));
       }
       $('#selling_price').val(sum);
   }


   function getUnit()
   {
      $.ajax({
          url: "{{route("unit.all")}}",
          type: "GET",
          success: function (response) {

              console.log(response)

              $.each(response, function (key, item) {
                   $(".unit").append(`<option value="${item.id}">${item.name}(${item.description})</option>`);
               });
              $('select').niceSelect('update');
          },
          error: function (error) {
             console.log(error)
          }

      });
   }


   $("#unitTypeForm").on("submit", function (event) {
            event.preventDefault();
            let formData = $(this).serializeArray();
            $.each(formData, function (key, message) {
                $("#" + formData[key].name + "_error").html("");
            });
            $.ajax({
                url: "{{route("unit_type.store")}}",
                data: formData,
                type: "POST",
                success: function (response) {
                    $("#new_unit").modal("hide");
                    $("#unitTypeForm").trigger("reset");
                    $('.unit').html('')
                    getUnit();
                },
                error: function (error) {
                    if (error) {
                        $.each(error.responseJSON.errors, function (key, message) {
                            $("#" + key + "_error").html(message[0]);
                        });
                    }
                }

            });
        });


      function getSubCategory(){
          $.ajax({
              url: "{{route("sub_category.all")}}",
              type: "GET",
              success: function (response) {

                  console.log(response)

                  $.each(response, function (key, item) {
                       $(".sub_category").append(`<option value="${item.id}">${item.name}</option>`);
                   });
                  $('select').niceSelect('update');
              },
              error: function (error) {
                 console.log(error)
              }

          });
       }



       $("#subcategoryForm").on("submit", function (event) {
           event.preventDefault();
           let formData = $(this).serializeArray();
           $.each(formData, function (key, message) {
               $("#" + formData[key].name + "_error").html("");
           });
           $.ajax({
               url: "{{route("category.store")}}",
               data: formData,
               type: "POST",
               success: function (response) {
                   $("#new_sub_cat").modal("hide");
                   $("#categoryForm").trigger("reset");
                   $(".parent_category").hide();
                   $('.sub_category').html('')

                   getSubCategory();

               },
               error: function (error) {
                   if (error) {
                       $.each(error.responseJSON.errors, function (key, message) {
                           $("#" + key + "_error").html(message[0]);
                       });
                   }
               }

           });
       });


       function getModel(){
          $.ajax({
              url: "{{route("model.all")}}",
              type: "GET",
              success: function (response) {

                  console.log(response)

                  $.each(response, function (key, item) {
                       $(".model").append(`<option value="${item.id}">${item.name}</option>`);
                   });
                  $('select').niceSelect('update');
              },
              error: function (error) {
                 console.log(error)
              }

          });
       }


       $("#modelTypeForm").on("submit", function (event) {
              event.preventDefault();
              let formData = $(this).serializeArray();
              $.each(formData, function (key, message) {
                  $("#" + formData[key].name + "_error").html("");
              });
              $.ajax({
                  url: "{{route("model.store")}}",
                  data: formData,
                  type: "POST",
                  success: function (response) {
                      $("#new_model").modal("hide");
                      $("#modelTypeForm").trigger("reset");
                      $('.model').html('')
                      getModel();
                  },
                  error: function (error) {
                      if (error) {
                          $.each(error.responseJSON.errors, function (key, message) {
                              $("#" + key + "_error").html(message[0]);
                          });
                      }
                  }

              });
          });


       function getBrand(){
          $.ajax({
              url: "{{route("brand.all")}}",
              type: "GET",
              success: function (response) {

                  console.log(response)

                  $.each(response, function (key, item) {
                       $(".brand").append(`<option value="${item.id}">${item.name}</option>`);
                   });
                  $('select').niceSelect('update');
              },
              error: function (error) {
                 console.log(error)
              }

          });
       }


       $("#brandForm").on("submit", function (event) {
              event.preventDefault();
              let formData = $(this).serializeArray();
              $.each(formData, function (key, message) {
                  $("#" + formData[key].name + "_error").html("");
              });
              $.ajax({
                  url: "{{route("brand.store")}}",
                  data: formData,
                  type: "POST",
                  success: function (response) {
                      $("#new_barnd").modal("hide");
                      $("#brandForm").trigger("reset");
                      $('.brand').html('')
                      getBrand();
                  },
                  error: function (error) {
                      if (error) {
                          $.each(error.responseJSON.errors, function (key, message) {
                              $("#" + key + "_error").html(message[0]);
                          });
                      }
                  }

              });
          });
                $(document).on("submit", ".product_add_form", function (event) {
                    event.preventDefault();
                    let formData = $(this).serializeArray();
                    
                    $.ajax({
                        url: "{{route("add_product.store")}}",
                        data: formData,
                        type: "POST",
                        dataType: "JSON",
                        success: function (response) {
                            $("#add_product").modal("hide");
                            $("#product_add_form").trigger("reset");
                            toastr.success('Product added Successfully. Please Add this into inventory.');
                        },
                        error: function (error) {
                            toastr.success('Something Went Wrong.');
                            if (error) {
                                $.each(error.responseJSON.errors, function (key, message) {
                                    $("#" + key + "_error").html(message[0]);
                                });
                            }
                        }
                    });
                });
                $(document).on("submit", ".contact_add_form", function (event) {
                    event.preventDefault();
                    let formData = $(this).serializeArray();
                    $.each(formData, function (key, message) {
                        $("#" + formData[key].name + "_error").html("");
                    });
                    $.ajax({
                        url: "{{route("add_contact.store")}}",
                        data: formData,
                        type: "POST",
                        dataType: "JSON",
                        success: function (response) {
                            $("#add_customer").modal("hide");
                            $("#contact_add_form").trigger("reset");
                            toastr.success(response.success);
                            $('.customer').html(response.output);
                            $('select').niceSelect('update');

                        },
                        error: function (error) {
                            if (error) {
                                $.each(error.responseJSON.errors, function (key, message) {
                                    $("#" + key + "_error").html(message[0]);
                                });
                            }
                        }
                    });
                });
            $(".contact_type").unbind().change(function () {
                let type = $(this).val();
                if (type === "Customer") {
                    $(".customer_type_section").show();
                } else {
                    $(".customer_type_section").hide();
                }
            });
            $('.summernote').summernote({
                height: 200
                });

        function get_district_by_division()
        {
            var division_id = $('#division_id').val();
          $.post('{{ route('get_district_by_division') }}',{_token:'{{ csrf_token() }}', division_id:division_id}, function(data){
                  $("#district_lists").html("");
                  let district = '';
                  district += `<select name="district_id" id="district_id" class="primary_select mb-15 district_lists" onchange="get_upazila_by_district()">`;
                  district += `<option>Select District</option>`;
                  $.each(data, function (key, item) {
                      district += `<option value="${item.id}">${item.name}</option>`;
                  });
                  district += `<select>`;
                  $("#district_lists").html(district);
                  $('.district_div').show();
                  $('select').niceSelect();
          });
        }

        function get_upazila_by_district()
        {
            var district_id = $('#district_id').val();
        $.post('{{ route('get_upazila_by_district') }}',{_token:'{{ csrf_token() }}', district_id:district_id}, function(data){
                $("#upazila_lists").html("");
                let upazila = '';
                upazila += `<select name="upazila_id" class="primary_select mb-15 upazila_lists>`;
                if (data.length > 0) {
                    $.each(data, function (key, item) {
                        upazila += `<option value="${item.id}">${item.name}</option>`;
                    });
                }else {
                    upazila += `<option value="">Choose Upazila</option>`;
                }
                upazila += `<select>`;
                $("#upazila_lists").html(upazila);
                $('.upazilla_div').show();
                $('select').niceSelect();
        });
        }
</script>
