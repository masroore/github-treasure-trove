<div class="form-group row align-items-center" :class="{'has-danger': errors.has('surname'), 'has-success': fields.surname && fields.surname.valid }">
    <label for="surname" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.passenger.columns.surname') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.surname" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('surname'), 'form-control-success': fields.surname && fields.surname.valid}" id="surname" name="surname" placeholder="{{ trans('admin.passenger.columns.surname') }}">
        <div v-if="errors.has('surname')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('surname') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('first_name'), 'has-success': fields.first_name && fields.first_name.valid }">
    <label for="first_name" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.passenger.columns.first_name') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.first_name" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('first_name'), 'form-control-success': fields.first_name && fields.first_name.valid}" id="first_name" name="first_name" placeholder="{{ trans('admin.passenger.columns.first_name') }}">
        <div v-if="errors.has('first_name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('first_name') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('second_name'), 'has-success': fields.second_name && fields.second_name.valid }">
    <label for="second_name" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.passenger.columns.second_name') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.second_name" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('second_name'), 'form-control-success': fields.second_name && fields.second_name.valid}" id="second_name" name="second_name" placeholder="{{ trans('admin.passenger.columns.second_name') }}">
        <div v-if="errors.has('second_name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('second_name') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('passport_series'), 'has-success': fields.passport_series && fields.passport_series.valid }">
    <label for="passport_series" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.passenger.columns.passport_series') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.passport_series" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('passport_series'), 'form-control-success': fields.passport_series && fields.passport_series.valid}" id="passport_series" name="passport_series" placeholder="{{ trans('admin.passenger.columns.passport_series') }}">
        <div v-if="errors.has('passport_series')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('passport_series') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('passport_number'), 'has-success': fields.passport_number && fields.passport_number.valid }">
    <label for="passport_number" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.passenger.columns.passport_number') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.passport_number" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('passport_number'), 'form-control-success': fields.passport_number && fields.passport_number.valid}" id="passport_number" name="passport_number" placeholder="{{ trans('admin.passenger.columns.passport_number') }}">
        <div v-if="errors.has('passport_number')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('passport_number') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('phone'), 'has-success': fields.phone && fields.phone.valid }">
    <label for="phone" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.passenger.columns.phone') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.phone" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('phone'), 'form-control-success': fields.phone && fields.phone.valid}" id="phone" name="phone" placeholder="{{ trans('admin.passenger.columns.phone') }}">
        <div v-if="errors.has('phone')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('phone') }}</div>
    </div>
</div>

<div class="form-check row" :class="{'has-danger': errors.has('deleted'), 'has-success': fields.deleted && fields.deleted.valid }">
    <div class="ml-md-auto" :class="isFormLocalized ? 'col-md-8' : 'col-md-10'">
        <input class="form-check-input" id="deleted" type="checkbox" v-model="form.deleted" v-validate="''" data-vv-name="deleted"  name="deleted_fake_element">
        <label class="form-check-label" for="deleted">
            {{ trans('admin.passenger.columns.deleted') }}
        </label>
        <input type="hidden" name="deleted" :value="form.deleted">
        <div v-if="errors.has('deleted')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('deleted') }}</div>
    </div>
</div>


