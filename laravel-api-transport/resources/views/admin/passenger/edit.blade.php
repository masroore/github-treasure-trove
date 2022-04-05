@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.passenger.actions.edit', ['name' => $passenger->first_name]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <passenger-form
                :action="'{{ $passenger->resource_url }}'"
                :data="{{ $passenger->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.passenger.actions.edit', ['name' => $passenger->first_name]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.passenger.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </passenger-form>

        </div>
    
</div>

@endsection