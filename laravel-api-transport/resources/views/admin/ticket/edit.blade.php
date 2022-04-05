@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.ticket.actions.edit', ['name' => $ticket->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <ticket-form
                :action="'{{ $ticket->resource_url }}'"
                :data="{{ $ticket->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.ticket.actions.edit', ['name' => $ticket->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.ticket.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </ticket-form>

        </div>
    
</div>

@endsection