<div {{  $attributes->merge( ['class'=>'text-3xl text-red-500 font-semibold']) }}>
    <div> titlke : {{  $title  }}</div>
    <div>{{ $info }}</div>

    <div class="text-green-500">{{ $something }}</div>
    Hello  Sidebar
    <ul>
        @foreach ($lists as $item)
        <li>{{  $item }}</li>
        @endforeach
    </ul>
</div>
