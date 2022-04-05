@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.route.actions.edit', ['name' => $route->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <route-form
                :action="'{{ $route->resource_url }}'"
                :data="{{ $route->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.route.actions.edit', ['name' => $route->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.route.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </route-form>

        </div>
    
</div>

@endsection