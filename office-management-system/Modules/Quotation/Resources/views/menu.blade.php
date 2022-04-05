@if(permissionCheck('quotation'))


@php

    $quotation = false;

    if(request()->is('quotation/*'))
    {
        $quotation = true;
    }

@endphp

<li class="{{ $quotation ?'mm-active' : '' }}">
    <a href="javascript:void (0);" class="has-arrow" aria-expanded="false">
        <div class="nav_icon_small">
            <span class="fas fa-coffee"></span>
        </div>
        <div class="nav_title">
            <span>{{__('quotation.Quotation')}}</span>
        </div>
    </a>
    <ul>
        @if (permissionCheck('quotation.index'))
            <li>
                <a href="{{route('quotation.index')}}" class="{{request()->is('quotation') || request()->is('quotation/*') ? 'active' : ''}}"> {{__('quotation.Quotation')}}</a>
            </li>
        @endif
    </ul>
</li>
@endif
