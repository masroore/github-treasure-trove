<div class="form-group row align-items-center" :class="{'has-danger': errors.has('post_name'), 'has-success': fields.post_name && fields.post_name.valid }">
    <label for="post_name" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.post.columns.post_name') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.post_name" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('post_name'), 'form-control-success': fields.post_name && fields.post_name.valid}" id="post_name" name="post_name" placeholder="{{ trans('admin.post.columns.post_name') }}">
        <div v-if="errors.has('post_name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('post_name') }}</div>
    </div>
</div>

<div class="form-check row" :class="{'has-danger': errors.has('deleted'), 'has-success': fields.deleted && fields.deleted.valid }">
    <div class="ml-md-auto" :class="isFormLocalized ? 'col-md-8' : 'col-md-10'">
        <input class="form-check-input" id="deleted" type="checkbox" v-model="form.deleted" v-validate="''" data-vv-name="deleted"  name="deleted_fake_element">
        <label class="form-check-label" for="deleted">
            {{ trans('admin.post.columns.deleted') }}
        </label>
        <input type="hidden" name="deleted" :value="form.deleted">
        <div v-if="errors.has('deleted')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('deleted') }}</div>
    </div>
</div>


