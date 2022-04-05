@extends('backEnd.master')
@section('mainContent')
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="white_box_50px box_shadow_white">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('account.Sale And Purchase Auto Approval') }}</h3>
                        </div>
                    </div>
                    <div class="row">
                        @foreach (Modules\Setting\Model\BusinessSetting::where('category_type', 'sale&purchase_type')->get() as $key => $approval)
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label" for="">{{ strtoupper(str_replace("_"," ",$approval->type)) }}</label>
                                    <label class="switch_toggle" for="checkbox{{ $approval->id }}">
                                        <input type="checkbox" id="checkbox{{ $approval->id }}" @if ($approval->status == 1) checked @endif value="{{ $approval->id }}" onchange="update_active_status(this)">
                                        <div class="slider round"></div>
                                    </label>
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@push('scripts')
    <script type="text/javascript">
    function update_active_status(el){
        if(el.checked){
            var status = 1;
        }
        else{
            var status = 0;
        }
        $.post('{{ route('update_activation_status') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
            if(data == 1){
                toastr.success("Successfully Updated","Success");
            }
            else{
                toastr.warning("Something went wrong");
            }
        });
    }
    </script>
@endpush
