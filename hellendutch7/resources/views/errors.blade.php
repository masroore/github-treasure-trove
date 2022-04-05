@if ($errors->{ $bag ?? 'default' }->any())
<div class="mb-4 rounded p-2 text-red-700 font-bold border-red-700 border-solid border-2">
        <ul class="field list-reset">
        @foreach ($errors->{ $bag ?? 'default' }->all() as $error)
            <li class="text-sm text-red">{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif