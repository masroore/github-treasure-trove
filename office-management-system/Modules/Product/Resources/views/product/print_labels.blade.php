@extends('backEnd.master')
@section('mainContent')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="box_header common_table_header">
                <div class="main-title d-md-flex">
                    <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('product.Print Label')}}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="white-box mt-2">
        <h3>{{__('product.Add Products to Generate Labels')}}</h3>
        <div class="row text-center">
            <!-- Start Sms Details -->
            <div class="col-lg-12">
                <div class="primary_input mb-15">
                    <label class="primary_input_label" for="">{{__('pos.Search Product')}}</label>
                    <input type="text" name="product" class="primary_input_field print_label"
                           placeholder="{{__('pos.Search Product')}}">
                </div>
            </div>
            <div class="col-md-12 col-lg-12 col-sm-12">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <td>{{__('common.Products')}}</td>
                        <td>{{__('product.No of Labels')}}</td>
                        <td>{{__('common.Action')}}</td>
                    </tr>
                    </thead>
                    <tbody class="product_details">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('backEnd.partials.delete_modal')
@endsection
@push("scripts")
    <script type="text/javascript">
        $(document).on('keyup', '.print_label', function () {
            let value = $(this).val();

            $.ajax({
                method: "POST",
                url: "{{route('search.product')}}",
                data: {
                    value: value,
                    _token: "{{csrf_token()}}"
                },
                success: function (result) {
                    $('.product_details').html(result);
                }
            })
        })
    </script>
@endpush
