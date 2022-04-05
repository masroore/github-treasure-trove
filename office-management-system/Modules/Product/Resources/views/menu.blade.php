        @if(permissionCheck('product'))
        @php

            $product = false;

            if(request()->is('product/*'))
            {
                $product = true;
            }

        @endphp
        <li class="{{ $product ?'mm-active' : '' }}">
            <a href="javascript:;" class="has-arrow" aria-expanded="{{ $product ? 'true' : 'false' }}">
                <div class="nav_icon_small">
                    <span class="fab fa-product-hunt"></span>
                </div>
                <div class="nav_title">
                    <span>{{__('common.Products')}}</span>
                </div>
            </a>
            <ul>

                @if(permissionCheck('add_product.create'))
                <li>
                    <a href="{{route('add_product.create')}}" class="{{request()->is('product/add_product/create') ? 'active' : ''}}"> {{__('common.Product List')}} </a>
                </li>

                <li>
                    <a href="{{route('add_product.service')}}" class="{{request()->is('product/add_product/service') ? 'active' : ''}}"> {{__('product.Service')}} </a>
                </li>
                @endif
                @if(permissionCheck('add_product.index'))
                <li>
                    <a href="{{route('add_product.index')}}" class="{{request()->is('product/add_product') ? 'active' : ''}}"> {{__('common.Add Product')}} </a>
                </li>
                @endif
               
                @if(permissionCheck('category.index'))
                <li>
                    <a href="{{route('category.index')}}" class="{{request()->is('product/category') ? 'active' : ''}}"> {{__('common.Category')}} </a>
                </li>
                @endif
                @if(permissionCheck('brand.index'))
                <li>
                    <a href="{{route('brand.index')}}" class="{{request()->is('product/brand') ? 'active' : ''}}"> {{__('common.Brand')}} </a>
                </li>
                @endif

                @if(permissionCheck('model.index'))
                <li>
                    <a href="{{route('model.index')}}" class="{{request()->is('product/model') ? 'active' : ''}}"> {{__('common.Model')}} </a>
                </li>
                @endif

                @if(permissionCheck('unit_type.index'))
                <li>
                    <a href="{{route('unit_type.index')}}" class="{{request()->is('product/unit_type') ? 'active' : ''}}"> {{__('common.Unit Type')}}</a>
                </li>
                @endif

                @if(permissionCheck('variant.index'))
                <li>
                    <a href="{{route('variant.index')}}" class="{{request()->is('product/variant') ? 'active' : ''}}"> {{__('common.Variant')}}</a>
                </li>
                @endif
            </ul>
        </li>

        @endif
