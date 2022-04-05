@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.office-user.actions.edit', ['name' => $officeUser->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <office-user-form
                :action="'{{ $officeUser->resource_url }}'"
                :data="{{ $officeUser->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.office-user.actions.edit', ['name' => $officeUser->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.office-user.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </office-user-form>

        </div>
    
</div>

@endsection