@extends('backEnd.master')
@section('mainContent')
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row justify-content-center">
                <div class="col-lg-4 mb_30 col-md-4">
                    <div class="box_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0" >{{ $language->name }} {{ __('common.Translation') }} </h3>
                        </div>
                    </div>
                    <div class="white-box">
                        <div class="row">
                            <div class="col-12">
                                <input type="hidden" name="id" id="id" value="{{ $language->id }}">
                                <div class="primary_input mb_15">
                                    <label class="primary_input_label" for=""> {{ __('common.Choose File') }}</label>
                                    <select name="file_name" id="file_name" class="primary_select mb-15" onchange="get_translate_file()">
                                        <option >{{__('setting.Select Translatable File')}}</option>
                                        @foreach ($files as $key => $value)

                                        @if(!(is_array($value)))
                                        @php
                                            $file_name = basename($value, '.php');
                                        @endphp
                                            <option value="{{ $file_name }}" @if ($key == 0) selected @endif>{{ $file_name }}</option>

                                        @else
                                            @foreach ($value as $k => $v)
                                            @php
                                                $file_name = $key .'::'.basename($v, '.php');
                                            @endphp
                                                <option value="{{ $file_name }}" >{{ ucwords($file_name) }}</option>
                                             @endforeach

                                        @endif
                                           
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 mt-50" id="translate_form">

                </div>
                <div class="row justify-content-center mt-30 demo_wait" style="display: none">
                    <img src="{{asset('backEnd/img/demo_wait.gif')}}" alt="">
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@push('scripts')
    <script type="text/javascript">
        $('.select2').select2();
        $( document ).ready(function() {
            $('.demo_wait').show();
            get_translate_file();
        });
        function get_translate_file(){
            var file_name = $('#file_name').val();
            var id = $('#id').val();
            $.post('{{ route('language.get_translate_file') }}', {_token:'{{ csrf_token() }}', file_name:file_name, id:id}, function(data){
                $('#translate_form').html(data);
                $('.demo_wait').hide();
            });
        }
    </script>
@endpush
