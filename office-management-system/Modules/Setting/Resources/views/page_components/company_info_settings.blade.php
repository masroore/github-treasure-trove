<!-- information_form  -->
<div class="main-title mb-25">
    <h3 class="mb-0">{{__('setting.Company Information')}}</h3>
</div>
<form action="#" method="post" id="company_info_form">
    <div class="row">
        <div class="col-xl-6">
            <div class="primary_input mb-25">
                <label class="primary_input_label" for="">{{__('setting.Company Name')}}</label>
                <input class="primary_input_field" placeholder="Infix CRM" type="text" id="company_name" name="company_name" value="{{ $setting->company_name }}">
            </div>
        </div>

        <div class="col-xl-6">
            <div class="primary_input mb-25">
                <label class="primary_input_label" for="">{{__('common.Email')}}</label>
                <input class="primary_input_field" placeholder="demo@infix.com" type="email" id="email" name="email" value="{{ $setting->email }}">
            </div>
        </div>

        <div class="col-xl-6">
            <div class="primary_input mb-25">
                <label class="primary_input_label" for="">{{__('retailer.Phone')}}</label>
                <input class="primary_input_field" placeholder="-" type="text" id="phone" name="phone" value="{{ $setting->phone }}">
            </div>
        </div>


        <div class="col-xl-6">
            <div class="primary_input mb-25">
                <label class="primary_input_label" for="">{{__('setting.VAT Number')}}</label>
                <input class="primary_input_field" placeholder="-" type="text" id="vat_number" name="vat_number" value="{{ $setting->vat_number }}">
            </div>
        </div>

        <div class="col-md-12">
            <div class="primary_input mb-25">
                <label class="primary_input_label" for="">{{__('setting.Address')}}</label>
                <input class="primary_input_field" placeholder="-" type="text" id="address" name="address" value="{{ $setting->address }}">
            </div>
        </div>

        <div class="col-xl-6">
            <div class="primary_input mb-25">
                <label class="primary_input_label" for="">{{__('setting.Country')}}</label>
                <input class="primary_input_field" placeholder="-" type="text" id="country_name" name="country_name" value="{{ $setting->country_name }}">
            </div>
        </div>

        <div class="col-xl-6">
            <div class="primary_input mb-25">
                <label class="primary_input_label" for="">{{__('setting.Zip Code')}}</label>
                <input class="primary_input_field" placeholder="-" type="text" id="zip_code" name="zip_code" value="{{ $setting->zip_code }}">
            </div>
        </div>

        <div class="col-xl-12">
            <div class="primary_input mb-25">
                <label class="primary_input_label" for="">{{__('setting.Company Information')}}</label>
            <textarea class="primary_textarea" placeholder="Company Info" id="company_info" cols="30" rows="10" name="company_info">{{ $setting->company_info }}</textarea>
            </div>
        </div>
    </div>
</form>
<div class="col-12 mb-10 pt_15">
    <div class="submit_btn text-center">
        <button class="primary_btn_large" onclick="company_info_form_submit()"> <i class="ti-check"></i> {{__('common.Save')}}</button>
    </div>
</div>
<!--/ information_form  -->
