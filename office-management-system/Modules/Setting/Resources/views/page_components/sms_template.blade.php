
<div class="main-title mb-20">
    <h3 class="mb-0">{{__('setting.SMS Template')}}</h3>
</div>
<div class="row">
    <div class="col-12">
        <ul id="sms_setting" class="permission_list sms_list mb-50 ">
            <li>
                <label data-id="CustomerDueSMS" class="primary_checkbox d-flex mr-12 ">
                    <input name="sms2" type="radio" checked>
                    <span class="checkmark"></span>
                </label>
                <p>{{__('setting.Customer Due SMS Template')}}</p>
            </li>
           
        </ul>
        <div id="CustomerDueSMS" class="sms_ption" >
            <form class="" action="{{ route('template_update') }}" method="post">
                @csrf
                <!-- content  -->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="">{{__('setting.Customer Due SMS Template')}}</label>
                            <textarea class="primary_textarea height_112" placeholder="{{__('setting.Message Body')}}" id="due_customer_sms_template" name="due_customer_sms_template">{{ $email_templates->where('type', 'due_customer_sms_template')->first()->value }}</textarea>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="">{{__('setting.Available Variables')}}</label>
                            <p  >{{ $email_templates->where('type', 'due_customer_sms_template')->first()->available_variable }}</p>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="sms_template" value="1">
                <input type="hidden" name="name" value="due_customer_sms_template">
                <div class="submit_btn text-center mb-100 pt_15">
                    <button class="primary_btn_large" type="submit"> <i class="ti-check"></i> {{ __('common.Save') }}</button>
                </div>
                <!-- content  -->
            </form>
        </div>
        
    </div>
</div>
