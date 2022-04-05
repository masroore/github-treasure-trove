<div>
    <div class="card">
        <div class="card-header">
            <div class="col-md-7 form-inline">
                Per Page: &nbsp;
                <select wire:model="perPage" class="form-control">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </div>
            <div class="col-md-5 mt-2">
                <input wire:model="search" class="form-control" type="text" placeholder="Search Users">
            </div>
        </div>
        <div class="card-body table-responsive bg-secondary">
            <table class="table">
                <thead>
                    <tr>
                        <th><a wire:click.prevent="sortBy('id')" role="button" href="#">
                                @include('admin.partials._sort-icon' , ['field' => 'id'])
                                ID
                            </a></th>
                        <th><a wire:click.prevent="sortBy('first_name')" role="button" href="#">
                                @include('admin.partials._sort-icon' , ['field' => 'first_name'])
                                Name
                            </a></th>
                        <th><a wire:click.prevent="sortBy('email')" role="button" href="#">
                                @include('admin.partials._sort-icon' , ['field' => 'email'])
                                Email
                            </a></th>
                        <th><a wire:click.prevent="sortBy('is_2fa_enabled')" role="button" href="#">
                                @include('admin.partials._sort-icon' , ['field' => 'is_2fa_enabled'])
                                2-Step
                            </a></th>
                        <th><a wire:click.prevent="sortBy('status')" role="button" href="#">
                                @include('admin.partials._sort-icon' , ['field' => 'status'])
                                Status
                            </a></th>
                        <th><a wire:click.prevent="sortBy('email_verified_at')" role="button" href="#">
                                @include('admin.partials._sort-icon' , ['field' => 'email_verified_at'])
                                Email Verified At
                            </a></th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>
                            {{ $user->id }}
                        </td>
                        <td>
                            {{ $user->first_name }} {{ $user->last_name }}
                        </td>
                        <td>
                            {{ $user->email }}
                        </td>
                        <td>
                            @if($user->two_step)
                            <span class="badge badge-success mr-4">
                                Enabled
                            </span>
                            @else
                            <span class="badge badge-danger mr-4">
                                Disabled
                            </span>
                            @endif
                        </td>
                        <td>
                            @if($user->status=='Active')
                            <span class="badge badge-success mr-4">
                                {{ $user->status }}
                            </span>
                            @else
                            <span class="badge badge-danger mr-4">
                                {{ $user->status }}
                            </span>
                            @endif
                        </td>
                        <td>
                            @if(! $user->email_verified_at)
                            <span class="badge badge-warning mr-4">
                                Unverified
                            </span>
                            @else
                            {{ $user->email_verified_at->format('d-M-Y | H:i:s') }}
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-dark"> View Details</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col">
                    {{ $users->links() }}
                </div>
                <div class="col text-right text-muted">
                    Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} out of {{ $users->total() }} results
                </div>
            </div>
        </div>
    </div>
</div>