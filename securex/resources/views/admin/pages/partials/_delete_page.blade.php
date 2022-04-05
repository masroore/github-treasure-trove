<div class="modal fade" id="delete-page-{{$page->id}}" >
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form class="" method="POST" action="{{ route('admin.pages.delete', $page) }}">
                @csrf
                @method('DELETE')
                <div class="card card-danger mb-0">
                    <div class="card-header">
                        <h4 class="text-danger">{{ __('admin.pages.delete_page') }}</h4>
                    </div>
                    <div class="modal-body">
                        <p>{!! Lang::get('admin.pages.delete_page_sub', ['title' => $page->title]) !!}</p>
                        <div class="form-group">
                            <label>{{ __('admin.pages.delete_confirm') }} <small class="text-danger">*</small></label>
                            <div class="input-group">
                                <select class="form-control" name="confirm" id="confirm" required>
                                    <option value="">{{ __('admin.pages.delete_confirm_select') }}</option>
                                    <option value="1">{{ __('admin.pages.delete_confirm_msg') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke">
                    <div class="mr-auto"><span class="text-danger">*</span> {{ __('vaults.input_req') }}</div>
                    <button type="submit" class="btn btn-danger btn-shadow"><i class="fas fa-trash"></i> {{ __('admin.pages.delete_page') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>