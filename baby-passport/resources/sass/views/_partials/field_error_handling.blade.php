@if ($errors->has($fieldName))
    <span class="invalid-feedback d-block" role="alert">
        <strong>{{ $errors->first($fieldName) }}</strong>
    </span>
@endif
