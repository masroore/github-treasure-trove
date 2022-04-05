<div>
    <form id="pages-form" wire:submit.prevent="addPage">
        @csrf
        <div class="card-body">
            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('admin.pages.title') }}</label>
                <div class="col-sm-12 col-md-7">
                    <input type="text" wire:model.lazy="title" placeholder="{{ __('admin.pages.title_placeholder') }}" class="form-control">
                    @error('title') <br/><span class="error text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('admin.pages.slug') }}</label>
                <div class="col-sm-12 col-md-7">
                    <input type="text" wire:model="slug" placeholder="{{ __('admin.pages.slug_placeholder') }}" class="form-control">
                    <span>{{ URL::to('/') }}/pages/{{ $this->slug }}</span>
                    @error('slug') <br/><span class="error text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('admin.pages.body') }}</label>
                <div class="col-sm-12 col-md-7">
                    <div class="form-control-wrap" wire:ignore>
                        <textarea type="text" id="body" class="form-control summernote"></textarea>
                    </div>
                    @error('body') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('admin.pages.last_updated') }}</label>
                <div class="col-sm-12 col-md-7">
                    <input type="date" wire:model.lazy="last_updated" id="last_updated" class="form-control {{ $errors->has('last_updated') ? 'is-invalid' : '' }}">
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
                    <button class="btn btn-primary">{{ __('admin.pages.add') }}</button>
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

$('#last_updated').on('change', function (e) {
    @this.set('last_updated', e.target.value);
});
</script>
@endpush
