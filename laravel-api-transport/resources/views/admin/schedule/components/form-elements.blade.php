<div class="form-group row align-items-center" :class="{'has-danger': errors.has('date'), 'has-success': fields.date && fields.date.valid }">
    <label for="date" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.schedule.columns.date') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-sm-8'">
        <div class="input-group input-group--custom">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            <datetime v-model="form.date" :config="datePickerConfig" v-validate="'required|date_format:yyyy-MM-dd HH:mm:ss'" class="flatpickr" :class="{'form-control-danger': errors.has('date'), 'form-control-success': fields.date && fields.date.valid}" id="date" name="date" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_a_date') }}"></datetime>
        </div>
        <div v-if="errors.has('date')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('date') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('time'), 'has-success': fields.time && fields.time.valid }">
    <label for="time" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.schedule.columns.time') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div class="input-group input-group--custom">
            <div class="input-group-addon"><i class="fa fa-clock-o"></i></div>
            <datetime v-model="form.time" :config="timePickerConfig" v-validate="'required|date_format:HH:mm:ss'" class="flatpickr" :class="{'form-control-danger': errors.has('time'), 'form-control-success': fields.time && fields.time.valid}" id="time" name="time" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_a_time') }}"></datetime>
        </div>
        <div v-if="errors.has('time')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('time') }}</div>
    </div>
</div>


<div class="form-group row align-items-center" :class="{'has-danger': errors.has('cost'), 'has-success': fields.cost && fields.cost.valid }">
    <label for="cost" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.schedule.columns.cost') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.cost" v-validate="'required|decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('cost'), 'form-control-success': fields.cost && fields.cost.valid}" id="cost" name="cost" placeholder="{{ trans('admin.schedule.columns.cost') }}">
        <div v-if="errors.has('cost')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('cost') }}</div>
    </div>
</div>

<div class="form-check row" :class="{'has-danger': errors.has('confirmed'), 'has-success': fields.confirmed && fields.confirmed.valid }">
    <div class="ml-md-auto" :class="isFormLocalized ? 'col-md-8' : 'col-md-10'">
        <input class="form-check-input" id="confirmed" type="checkbox" v-model="form.confirmed" v-validate="''" data-vv-name="confirmed"  name="confirmed_fake_element">
        <label class="form-check-label" for="confirmed">
            {{ trans('admin.schedule.columns.confirmed') }}
        </label>
        <input type="hidden" name="confirmed" :value="form.confirmed">
        <div v-if="errors.has('confirmed')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('confirmed') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('transport_id'), 'has-success': fields.transport_id && fields.transport_id.valid }">
    <label for="transport_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.schedule.columns.transport_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.transport_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('transport_id'), 'form-control-success': fields.transport_id && fields.transport_id.valid}" id="transport_id" name="transport_id" placeholder="{{ trans('admin.schedule.columns.transport_id') }}">
        <div v-if="errors.has('transport_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('transport_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('route_id'), 'has-success': fields.route_id && fields.route_id.valid }">
    <label for="route_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.schedule.columns.route_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.route_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('route_id'), 'form-control-success': fields.route_id && fields.route_id.valid}" id="route_id" name="route_id" placeholder="{{ trans('admin.schedule.columns.route_id') }}">
        <div v-if="errors.has('route_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('route_id') }}</div>
    </div>
</div>

<div class="form-check row" :class="{'has-danger': errors.has('deleted'), 'has-success': fields.deleted && fields.deleted.valid }">
    <div class="ml-md-auto" :class="isFormLocalized ? 'col-md-8' : 'col-md-10'">
        <input class="form-check-input" id="deleted" type="checkbox" v-model="form.deleted" v-validate="''" data-vv-name="deleted"  name="deleted_fake_element">
        <label class="form-check-label" for="deleted">
            {{ trans('admin.schedule.columns.deleted') }}
        </label>
        <input type="hidden" name="deleted" :value="form.deleted">
        <div v-if="errors.has('deleted')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('deleted') }}</div>
    </div>
</div>


