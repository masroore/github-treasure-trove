@if(permissionCheck('contact'))

@php

$contact = false;

if(request()->is('contact/*'))
{
$contact = true;
}

@endphp

<li class="{{ $contact ?'mm-active' : '' }}">
    <a href="javascript:void (0);" class="has-arrow" aria-expanded="false">
        <div class="nav_icon_small">
            <span class="fas fa-file-contract"></span>
        </div>
        <div class="nav_title">
            <span>{{__('common.Contacts')}}</span>
        </div>
    </a>
    <ul>
        @if(permissionCheck('add_contact.store'))
        <li>
            <a href="{{route('add_contact.index')}}"> {{__('common.Add Contacts')}} </a>
        </li>
        @endif

        @if(permissionCheck('supplier'))
        <li>
            <a href="{{route('supplier')}}"> {{__('common.Supplier')}} </a>
        </li>
        @endif

        @if(permissionCheck('customer'))
        <li>
            <a href="{{route('customer')}}"> {{__('common.Customer')}} </a>
        </li>
        @endif
        @if(permissionCheck('contact.settings'))
        <li>
            <a href="{{route('contact.settings')}}"> {{__('common.Settings')}} </a>
        </li>
        @endif
     
    </ul>
</li>
@endif

@if (auth()->user()->role_id == 5 or auth()->user()->role_id == 4)
<li class="{{ request()->is('my_details') ?'mm-active' : '' }}">
    <a href="{{ route('contact.my_details') }}">
        <div class="nav_icon_small">
            <span class="fas fa-file-contract"></span>
        </div>
        <div class="nav_title">
            <span>{{__('common.My Details')}}</span>
        </div>
    </a>
</li>

<li class="{{ request()->is('invoice') ?'mm-active' : '' }}">
    <a href="{{ route('contact.invoice') }}">
        <div class="nav_icon_small">
            <span class="fas fa-file-contract"></span>
        </div>
        <div class="nav_title">
            <span>{{__('common.Invoice')}}</span>
        </div>
    </a>
</li>

<li class="{{ request()->is('return') ?'mm-active' : '' }}">
    <a href="{{ route('contact.return') }}">
        <div class="nav_icon_small">
            <span class="fas fa-file-contract"></span>
        </div>
        <div class="nav_title">
            <span>{{__('common.Return')}}</span>
        </div>
    </a>
</li>

<li class="{{ request()->is('transaction') ?'mm-active' : '' }}">
    <a href="{{ route('contact.transaction') }}">
        <div class="nav_icon_small">
            <span class="fas fa-file-contract"></span>
        </div>
        <div class="nav_title">
            <span>{{__('common.Transaction')}}</span>
        </div>
    </a>
</li>
@endif

