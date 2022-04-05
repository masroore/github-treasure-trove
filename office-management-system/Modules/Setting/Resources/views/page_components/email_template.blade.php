<div class="main-title mb-20">
    <h3 class="mb-0">{{__('setting.Email Template')}}</h3>
</div>
<div class="row">
    <div class="col-12">
        <ul id="sms_setting" class="permission_list sms_list mb-50 template_checkbox">
            @php
                $templates = \Modules\Setting\Model\EmailTemplate::where(['for' => 'email'])->get();
            @endphp
            @foreach($templates as $template)
                <li>
                    <label data-id="{{ $template->type }}" class="primary_checkbox d-flex mr-12 ">
                        <input name="sms1" type="radio" @if($loop->index == 0) checked="checked" @endif>
                        <span class="checkmark"></span>
                    </label>
                    <p>{{__('setting.'.$template->type)}}</p>
                </li>

            @endforeach


        </ul>
        @foreach($templates as $template)
        <div id="{{ $template->type }}" class="sms_ption" {!! $loop->index != 0 ? 'style="display:none;"' : '' !!}>
            <form class="" action="{{ route('template_update') }}" method="post">
                @csrf
                <!-- content  -->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="">{{__('setting.Subject')}}</label>
                            <input type="text" name="subject" class="primary_input_field" value="{{ $template->subject }}" placeholder="{{__('setting.Subject')}}">
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="">{{__('setting.Quotation Template')}}</label>
                            <textarea name="{{ $template->type }}" class="summernote3" placeholder="" >{{ $template->value }}</textarea>
                        </div>
                    </div>

                    <div class="col-xl-12">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="">{{__('setting.Available Variables')}}</label>
                            <p> {{ $template->available_variable }} </p>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="name" value="{{ $template->type }}">
                <div class="submit_btn text-center mb-100 pt_15">
                    <button class="primary_btn_large" type="submit"> <i class="ti-check"></i> {{ __('common.Save') }}</button>
                </div>
                <!-- content  -->
            </form>
        </div>
        @endforeach

    </div>
</div>
