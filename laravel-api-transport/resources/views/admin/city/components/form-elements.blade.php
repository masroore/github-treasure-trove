<div class="form-group row align-items-center" :class="{'has-danger': errors.has('city_name'), 'has-success': fields.city_name && fields.city_name.valid }">
    <label for="city_name" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.city.columns.city_name') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.city_name" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('city_name'), 'form-control-success': fields.city_name && fields.city_name.valid}" id="city_name" name="city_name" placeholder="{{ trans('admin.city.columns.city_name') }}">
        <div v-if="errors.has('city_name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('city_name') }}</div>
    </div>
</div>

<div class="form-check row" :class="{'has-danger': errors.has('deleted'), 'has-success': fields.deleted && fields.deleted.valid }">
    <div class="ml-md-auto" :class="isFormLocalized ? 'col-md-8' : 'col-md-10'">
        <input class="form-check-input" id="deleted" type="checkbox" v-model="form.deleted" v-validate="''" data-vv-name="deleted"  name="deleted_fake_element">
        <label class="form-check-label" for="deleted">
            {{ trans('admin.city.columns.deleted') }}
        </label>
        <input type="hidden" name="deleted" :value="form.deleted">
        <div v-if="errors.has('deleted')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('deleted') }}</div>
    </div>
</div>


