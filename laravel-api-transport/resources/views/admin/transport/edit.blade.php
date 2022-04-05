@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.transport.actions.edit', ['name' => $transport->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <transport-form
                :action="'{{ $transport->resource_url }}'"
                :data="{{ $transport->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.transport.actions.edit', ['name' => $transport->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.transport.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </transport-form>

        </div>
    
</div>

@endsection