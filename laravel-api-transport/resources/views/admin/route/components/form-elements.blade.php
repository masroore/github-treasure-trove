<div class="form-group row align-items-center" :class="{'has-danger': errors.has('departure_city_id'), 'has-success': fields.departure_city_id && fields.departure_city_id.valid }">
    <label for="departure_city_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.route.columns.departure_city_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.departure_city_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('departure_city_id'), 'form-control-success': fields.departure_city_id && fields.departure_city_id.valid}" id="departure_city_id" name="departure_city_id" placeholder="{{ trans('admin.route.columns.departure_city_id') }}">
        <div v-if="errors.has('departure_city_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('departure_city_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('arrival_city_id'), 'has-success': fields.arrival_city_id && fields.arrival_city_id.valid }">
    <label for="arrival_city_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.route.columns.arrival_city_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.arrival_city_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('arrival_city_id'), 'form-control-success': fields.arrival_city_id && fields.arrival_city_id.valid}" id="arrival_city_id" name="arrival_city_id" placeholder="{{ trans('admin.route.columns.arrival_city_id') }}">
        <div v-if="errors.has('arrival_city_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('arrival_city_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('distance'), 'has-success': fields.distance && fields.distance.valid }">
    <label for="distance" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.route.columns.distance') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.distance" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('distance'), 'form-control-success': fields.distance && fields.distance.valid}" id="distance" name="distance" placeholder="{{ trans('admin.route.columns.distance') }}">
        <div v-if="errors.has('distance')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('distance') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('user_id'), 'has-success': fields.user_id && fields.user_id.valid }">
    <label for="user_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.route.columns.user_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.user_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('user_id'), 'form-control-success': fields.user_id && fields.user_id.valid}" id="user_id" name="user_id" placeholder="{{ trans('admin.route.columns.user_id') }}">
        <div v-if="errors.has('user_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('user_id') }}</div>
    </div>
</div>

<div class="form-check row" :class="{'has-danger': errors.has('deleted'), 'has-success': fields.deleted && fields.deleted.valid }">
    <div class="ml-md-auto" :class="isFormLocalized ? 'col-md-8' : 'col-md-10'">
        <input class="form-check-input" id="deleted" type="checkbox" v-model="form.deleted" v-validate="''" data-vv-name="deleted"  name="deleted_fake_element">
        <label class="form-check-label" for="deleted">
            {{ trans('admin.route.columns.deleted') }}
        </label>
        <input type="hidden" name="deleted" :value="form.deleted">
        <div v-if="errors.has('deleted')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('deleted') }}</div>
    </div>
</div>


