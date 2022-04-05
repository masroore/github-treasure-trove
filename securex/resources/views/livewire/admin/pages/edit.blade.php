<div>
    <form id="pages-form" wire:submit.prevent="updatePage">
        @csrf
        <div class="card-body">
            @if($page->status == 'Draft')
            <div class="custom-error">
                <div class="cerror warning">
                    <strong>@lang('alerts.warning')</strong> {{ __('alerts.admin.pages.visibility') }}
                </div>
            </div>
            @endif
            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('admin.pages.title') }}</label>
                <div class="col-sm-12 col-md-7">
                    <input type="text" wire:model.lazy="title" placeholder="{{ __('admin.pages.title_placeholder') }}" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('admin.pages.slug') }}</label>
                <div class="col-sm-12 col-md-5">
                    <input type="text" wire:model="slug" placeholder="{{ __('admin.pages.slug_placeholder') }}" class="form-control">
                    <span>{{ URL::to('/') }}/pages/{{ $this->slug }}</span>
                    @error('slug') <br/><span class="error text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="col-sm3 col-md-3">
                    <a href="{{ url('/pages/'.$page->slug) }}" target="_blank" class="btn btn-primary btn_icon"><i class="fas fa-eye"></i> View Page</a>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('admin.pages.body') }}</label>
                <div class="col-sm-12 col-md-7">
                    <div class="form-control-wrap" wire:ignore>
                        <textarea type="text" id="body" class="form-control summernote">{{ $page->body }}</textarea>
                    </div>
                    @error('body') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('admin.pages.last_updated') }} <br/><small>(DD-MM-YYYY)</small></label>
                <div class="col-sm-12 col-md-7">
                    <input type="text" id="last_updated" class="form-control" placeholder="DD-MM-YYYY" value="{{ $this->last_updated }}">
                    @error('last_updated') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('admin.pages.status') }}</label>
                <div class="col-sm-12 col-md-7">
                    <select class="form-control selectric" wire:model.lazy="status" required>
                        <option value="{{ __('admin.pages.published') }}">{{ __('admin.pages.published') }}</option>
                        <option value="{{ __('admin.pages.draft') }}">{{ __('admin.pages.draft') }}</option>
                    </select>
                </div>
            </div>
            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                <div class="col-sm-12 col-md-7">
                    <button class="btn btn-primary">{{ __('admin.pages.update') }}</button>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script src="{{ asset('assets/vendor/summernote/summernote-bs4.js') }}"></script>
<script>
$('#body').summernote({
    tabsize: 2,
    height: 200,
    focus: true,
    toolbar: [
        // [groupName, [list of button]]
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['font', ['strikethrough', 'superscript', 'subscript']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['height', ['height']]
    ],
    callbacks: {
        onChange: function(contents, $editable) {
            @this.set('body', contents);
        }
    }
});
document.getElementById('pages-form').ondragstart = function () { return false; };
</script>
<script src="{{ asset('assets/js/modules/bootstrap-formhelpers.js') }}"></script>
<script src="{{ asset('assets/js/modules/jquery.mask.min.js') }}"></script>
<script>
$(document).ready(function() {
    $('#last_updated').mask('00-00-0000');
});
  
$('#last_updated').on('change', function (e) {
    @this.set('last_updated', e.target.value);
});
window.livewire.on('pageUpdated', msg => {
  notyf.open({
      type: 'success',
      message: msg
  });
});
</script>
@endpush
