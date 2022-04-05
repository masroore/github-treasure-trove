
<ul>
@foreach($childs as $child)
	<li>
	@if(count($child->chart_accounts))
		+ {{ $child->name }}
        @include('account::chart_accounts.childs',['childs' => $child->chart_accounts])
	@else
		- {{ $child->name }}
    @endif
	</li>
@endforeach
</ul>
