@if (strtolower($type) == 'matriz')
@if ($cant < 2 && $ladouser == $side)
<li>
    <a href="javascript:;" class="met">
        <img src="{{asset('assets/img/add_tree.png')}}"
        alt="">
    </a>
</li>
@endif
@endif