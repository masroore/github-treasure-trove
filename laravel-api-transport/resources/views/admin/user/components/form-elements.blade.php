<div class="form-group row align-items-center" :class="{'has-danger': errors.has('email'), 'has-success': fields.email && fields.email.valid }">
    <label for="email" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.email') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.email" v-validate="'required|email'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('email'), 'form-control-success': fields.email && fields.email.valid}" id="email" name="email" placeholder="{{ trans('admin.user.columns.email') }}">
        <div v-if="errors.has('email')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('email') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('password'), 'has-success': fields.password && fields.password.valid }">
    <label for="password" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.password') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="password" v-model="form.password" v-validate="'min:7'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('password'), 'form-control-success': fields.password && fields.password.valid}" id="password" name="password" placeholder="{{ trans('admin.user.columns.password') }}" ref="password">
        <div v-if="errors.has('password')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('password') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('password_confirmation'), 'has-success': fields.password_confirmation && fields.password_confirmation.valid }">
    <label for="password_confirmation" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.password_repeat') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="password" v-model="form.password_confirmation" v-validate="'confirmed:password|min:7'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('password_confirmation'), 'form-control-success': fields.password_confirmation && fields.password_confirmation.valid}" id="password_confirmation" name="password_confirmation" placeholder="{{ trans('admin.user.columns.password') }}" data-vv-as="password">
        <div v-if="errors.has('password_confirmation')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('password_confirmation') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('surname'), 'has-success': fields.surname && fields.surname.valid }">
    <label for="surname" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.surname') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.surname" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('surname'), 'form-control-success': fields.surname && fields.surname.valid}" id="surname" name="surname" placeholder="{{ trans('admin.user.columns.surname') }}">
        <div v-if="errors.has('surname')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('surname') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('first_name'), 'has-success': fields.first_name && fields.first_name.valid }">
    <label for="first_name" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.first_name') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.first_name" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('first_name'), 'form-control-success': fields.first_name && fields.first_name.valid}" id="first_name" name="first_name" placeholder="{{ trans('admin.user.columns.first_name') }}">
        <div v-if="errors.has('first_name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('first_name') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('second_name'), 'has-success': fields.second_name && fields.second_name.valid }">
    <label for="second_name" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.second_name') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.second_name" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('second_name'), 'form-control-success': fields.second_name && fields.second_name.valid}" id="second_name" name="second_name" placeholder="{{ trans('admin.user.columns.second_name') }}">
        <div v-if="errors.has('second_name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('second_name') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('passport_series'), 'has-success': fields.passport_series && fields.passport_series.valid }">
    <label for="passport_series" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.passport_series') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.passport_series" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('passport_series'), 'form-control-success': fields.passport_series && fields.passport_series.valid}" id="passport_series" name="passport_series" placeholder="{{ trans('admin.user.columns.passport_series') }}">
        <div v-if="errors.has('passport_series')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('passport_series') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('passport_number'), 'has-success': fields.passport_number && fields.passport_number.valid }">
    <label for="passport_number" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.passport_number') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.passport_number" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('passport_number'), 'form-control-success': fields.passport_number && fields.passport_number.valid}" id="passport_number" name="passport_number" placeholder="{{ trans('admin.user.columns.passport_number') }}">
        <div v-if="errors.has('passport_number')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('passport_number') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('inn'), 'has-success': fields.inn && fields.inn.valid }">
    <label for="inn" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.inn') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.inn" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('inn'), 'form-control-success': fields.inn && fields.inn.valid}" id="inn" name="inn" placeholder="{{ trans('admin.user.columns.inn') }}">
        <div v-if="errors.has('inn')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('inn') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('scan'), 'has-success': fields.scan && fields.scan.valid }">
    <label for="scan" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.scan') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.scan" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('scan'), 'form-control-success': fields.scan && fields.scan.valid}" id="scan" name="scan" placeholder="{{ trans('admin.user.columns.scan') }}">
        <div v-if="errors.has('scan')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('scan') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('birthday'), 'has-success': fields.birthday && fields.birthday.valid }">
    <label for="birthday" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.birthday') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-sm-8'">
        <div class="input-group input-group--custom">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            <datetime v-model="form.birthday" :config="datePickerConfig" v-validate="'required|date_format:yyyy-MM-dd HH:mm:ss'" class="flatpickr" :class="{'form-control-danger': errors.has('birthday'), 'form-control-success': fields.birthday && fields.birthday.valid}" id="birthday" name="birthday" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_a_date') }}"></datetime>
        </div>
        <div v-if="errors.has('birthday')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('birthday') }}</div>
    </div>
</div>

<div class="form-check row" :class="{'has-danger': errors.has('deleted'), 'has-success': fields.deleted && fields.deleted.valid }">
    <div class="ml-md-auto" :class="isFormLocalized ? 'col-md-8' : 'col-md-10'">
        <input class="form-check-input" id="deleted" type="checkbox" v-model="form.deleted" v-validate="''" data-vv-name="deleted"  name="deleted_fake_element">
        <label class="form-check-label" for="deleted">
            {{ trans('admin.user.columns.deleted') }}
        </label>
        <input type="hidden" name="deleted" :value="form.deleted">
        <div v-if="errors.has('deleted')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('deleted') }}</div>
    </div>
</div>

<div class="form-check row" :class="{'has-danger': errors.has('dismissed'), 'has-success': fields.dismissed && fields.dismissed.valid }">
    <div class="ml-md-auto" :class="isFormLocalized ? 'col-md-8' : 'col-md-10'">
        <input class="form-check-input" id="dismissed" type="checkbox" v-model="form.dismissed" v-validate="''" data-vv-name="dismissed"  name="dismissed_fake_element">
        <label class="form-check-label" for="dismissed">
            {{ trans('admin.user.columns.dismissed') }}
        </label>
        <input type="hidden" name="dismissed" :value="form.dismissed">
        <div v-if="errors.has('dismissed')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('dismissed') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('api_token'), 'has-success': fields.api_token && fields.api_token.valid }">
    <label for="api_token" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.api_token') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.api_token" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('api_token'), 'form-control-success': fields.api_token && fields.api_token.valid}" id="api_token" name="api_token" placeholder="{{ trans('admin.user.columns.api_token') }}">
        <div v-if="errors.has('api_token')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('api_token') }}</div>
    </div>
</div>


