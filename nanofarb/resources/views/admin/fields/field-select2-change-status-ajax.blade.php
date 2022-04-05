<div class="form-group field-select2-change-status-ajax" data-route="{{ $data_url ?? '#' }}">
    <select 
        name="{{ $field_name ?? '' }}"
        data-minimum-results-for-search="Infinity" 
        class="form-control select2 select2-change-status-ajax" 
        style="width: 100%;"
    >
        @php
            $selected = isset($selected) ? (is_array($selected) ? $selected : [$selected]) : [];
            $attributes = isset($attributes) && is_array($attributes) ? $attributes : [];
        @endphp
        @foreach($attributes as $value => $title)
            <option value="{{ $value }}" @if(in_array($value, $selected)) selected @endif>{{ $title }}</option>
        @endforeach
    </select>
    <div class="overlay hidden">
        <i class="fa fa-refresh fa-spin"></i>
    </div>
</div>