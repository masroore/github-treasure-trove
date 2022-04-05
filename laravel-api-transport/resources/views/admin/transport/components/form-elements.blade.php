<div class="form-group row align-items-center" :class="{'has-danger': errors.has('car_number'), 'has-success': fields.car_number && fields.car_number.valid }">
    <label for="car_number" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.transport.columns.car_number') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.car_number" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('car_number'), 'form-control-success': fields.car_number && fields.car_number.valid}" id="car_number" name="car_number" placeholder="{{ trans('admin.transport.columns.car_number') }}">
        <div v-if="errors.has('car_number')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('car_number') }}</div>
    </div>
</div>

<div class="form-check row" :class="{'has-danger': errors.has('total_seats'), 'has-success': fields.total_seats && fields.total_seats.valid }">
    <div class="ml-md-auto" :class="isFormLocalized ? 'col-md-8' : 'col-md-10'">
        <input class="form-check-input" id="total_seats" type="checkbox" v-model="form.total_seats" v-validate="''" data-vv-name="total_seats"  name="total_seats_fake_element">
        <label class="form-check-label" for="total_seats">
            {{ trans('admin.transport.columns.total_seats') }}
        </label>
        <input type="hidden" name="total_seats" :value="form.total_seats">
        <div v-if="errors.has('total_seats')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('total_seats') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('model_id'), 'has-success': fields.model_id && fields.model_id.valid }">
    <label for="model_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.transport.columns.model_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.model_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('model_id'), 'form-control-success': fields.model_id && fields.model_id.valid}" id="model_id" name="model_id" placeholder="{{ trans('admin.transport.columns.model_id') }}">
        <div v-if="errors.has('model_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('model_id') }}</div>
    </div>
</div>

<div class="form-check row" :class="{'has-danger': errors.has('deleted'), 'has-success': fields.deleted && fields.deleted.valid }">
    <div class="ml-md-auto" :class="isFormLocalized ? 'col-md-8' : 'col-md-10'">
        <input class="form-check-input" id="deleted" type="checkbox" v-model="form.deleted" v-validate="''" data-vv-name="deleted"  name="deleted_fake_element">
        <label class="form-check-label" for="deleted">
            {{ trans('admin.transport.columns.deleted') }}
        </label>
        <input type="hidden" name="deleted" :value="form.deleted">
        <div v-if="errors.has('deleted')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('deleted') }}</div>
    </div>
</div>


