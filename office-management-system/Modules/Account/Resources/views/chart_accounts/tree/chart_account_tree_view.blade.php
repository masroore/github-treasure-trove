<div class="col-xl-4 card mt-4">
    <ul class="tree mt-4" id="tree1">
        @foreach(\Modules\Account\Entities\ChartAccount::where('parent_id', null)->get() as $category)
           <li>
               @if(count($category->chart_accounts))
                   + {{ $category->name }}
                   @include('account::chart_accounts.childs',['childs' => $category->chart_accounts])
               @else
                   - {{ $category->name }}
               @endif
           </li>
       @endforeach
   </ul>
</div>


@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {

            $(".as_sub_category").unbind().click(function () {
                $(".parent_chartAccount").toggle();
            });


            $(".as_sub_category_edit").unbind().click(function () {
                $(".edit_parent_chartAccount").toggle();
                parentChartAccount("edit_parent_chartAccount_list");
            });

            chartAccountList();
            parentChartAccount();
            $("#chart_account_form").on("submit", function (event) {
                event.preventDefault();
                let formData = $(this).serializeArray();
                $.each(formData, function (key, message) {
                    $("#" + formData[key].name + "_error").html("");
                });
                $.ajax({
                    url: "{{route("char_accounts.store")}}",
                    data: formData,
                    type: "POST",
                    success: function (response) {
                        $("#Item_Details").modal("hide");
                        $("#chart_account_form").trigger("reset");
                        $(".parent_chartAccount").hide();
                        chartAccountList();
                        parentChartAccount();

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


            $("#chart_account_list").on("click", ".edit_chart_account", function () {
                let id = $(this).data("value");
                $(".as_sub_category_edit").attr("checked", false);
                $(".edit_parent_chartAccount").hide();
                $.ajax({
                    url: "/account/chart-account/" + id + "/edit",
                    type: "GET",
                    success: function (response) {
                        $(".edit_id").val(response.id);
                        if (response.parent_id) {
                            $(".as_sub_category_edit").attr("checked", true);
                            $(".edit_parent_chartAccount").show();
                            parentChartAccount("edit_parent_chartAccount_list", response.parent_id);
                        }
                        $("#type_edit option[value=3]").attr('selected', 'selected');
                        // $("#type_edit > option > [value=" + response.type + "]").attr("selected", "true");
                        $('#type_edit').niceSelect('update');
                        $(".name").val(response.name);
                        $(".description").val(response.description);
                        if (response.status === 1) {
                            $(".active").attr("checked", true);
                        } else {
                            $(".de_active").attr("checked", true);
                        }
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            });

            $(document).on("submit", "#ChartAccountEditForm", function (event) {
                event.preventDefault();
                let id = $(".edit_id").val();
                let formData = $(this).serializeArray();
                $.each(formData, function (key, message) {
                    $("#edit_" + formData[key].name + "_error").html("");
                });
                $.ajax({
                    url: "/account/chart-account/update/" + id,
                    data: formData,
                    type: "POST",
                    dataType: "JSON",
                    success: function (response) {
                        $("#ChartAccount_Edit").modal("hide");
                        $("#ChartAccountEditForm").trigger("reset");
                        $(".active").attr("checked", false);
                        $(".de_active").attr("checked", false);
                        chartAccountList();
                    },
                    error: function (error) {
                        if (error) {
                            $.each(error.responseJSON.errors, function (key, message) {
                                $("#edit_" + key + "_error").html(message[0]);
                            });
                        }
                    }
                });
            });

            function chartAccountList() {
                $.ajax({
                    url: "{{route("char_accounts.create")}}",
                    type: "GET",
                    dataType: "HTML",
                    success: function (response) {
                        $("#chart_account_list").html(response);
                        // $(".table").dataTable();
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            }

            function parentChartAccount(type = null, selected = null) {
                $.ajax({
                    url: "{{route("chart_accounts.parent")}}",
                    type: "GET",
                    dataType: "JSON",
                    success: function (response) {
                        if (type) {
                            $("#" + type).html("");
                        } else {
                            $("#parent_chart_account_list").html("");
                        }
                        let parent_chartAccount = '';
                        parent_chartAccount += `<select name="parent_id" class="primary_select mb-15 parent_chart_account_list">`;
                        $.each(response, function (key, item) {
                            if (selected && selected === item.id) {
                                parent_chartAccount += `<option selected value="${item.id}">${item.name}</option>`;
                            } else {
                                parent_chartAccount += `<option value="${item.id}">${item.name}</option>`;
                            }
                        });
                        parent_chartAccount += `<select>`;
                        if (type) {
                            console.log(type);
                            $("#" + type).html(parent_chartAccount);
                        } else {
                            $("#parent_chart_account_list").html(parent_chartAccount);
                        }
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            }
        });

    </script>
@endpush
