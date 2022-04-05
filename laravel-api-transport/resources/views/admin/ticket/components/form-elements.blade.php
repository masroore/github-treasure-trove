<div class="form-group row align-items-center" :class="{'has-danger': errors.has('passenger_id'), 'has-success': fields.passenger_id && fields.passenger_id.valid }">
    <label for="passenger_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.ticket.columns.passenger_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.passenger_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('passenger_id'), 'form-control-success': fields.passenger_id && fields.passenger_id.valid}" id="passenger_id" name="passenger_id" placeholder="{{ trans('admin.ticket.columns.passenger_id') }}">
        <div v-if="errors.has('passenger_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('passenger_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('schedule_id'), 'has-success': fields.schedule_id && fields.schedule_id.valid }">
    <label for="schedule_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.ticket.columns.schedule_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.schedule_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('schedule_id'), 'form-control-success': fields.schedule_id && fields.schedule_id.valid}" id="schedule_id" name="schedule_id" placeholder="{{ trans('admin.ticket.columns.schedule_id') }}">
        <div v-if="errors.has('schedule_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('schedule_id') }}</div>
    </div>
</div>

<div class="form-check row" :class="{'has-danger': errors.has('deleted'), 'has-success': fields.deleted && fields.deleted.valid }">
    <div class="ml-md-auto" :class="isFormLocalized ? 'col-md-8' : 'col-md-10'">
        <input class="form-check-input" id="deleted" type="checkbox" v-model="form.deleted" v-validate="''" data-vv-name="deleted"  name="deleted_fake_element">
        <label class="form-check-label" for="deleted">
            {{ trans('admin.ticket.columns.deleted') }}
        </label>
        <input type="hidden" name="deleted" :value="form.deleted">
        <div v-if="errors.has('deleted')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('deleted') }}</div>
    </div>
</div>


