    <div class="font-sans card bg-grey-light mx-4 mt-2 md:ml-0 md:w-1/6">

        <x-menus.group groupname='Home'>
            <x-menus.item routename='root'>Catalogue</x-menus.item>
            <li><a href="{{ url('/theartist') }}" class="hover:font-semibold no-underline">The Artist</a></li>
            <li><a href="{{ url('/whyborneo') }}" class="hover:font-semibold no-underline">Why Borneo</a></li>
            <li><a href="{{ url('/materials') }}" class="hover:font-semibold no-underline">Use of Materials</a></li>
            <li><a href="{{ url('/contactme') }}" class="hover:font-semibold no-underline">Contact Me</a></li>
        </x-menus.group>

        <x-menus.group groupname='By Category'>
            <ul>
                @forelse($categories as $category)
                <li><a href="{{ url('/bycategory/'. $category->id ) }}" class="hover:font-semibold">{{ $category->category }}</li></a>
                @empty
                <div class=" mx-2"> No Pictures Yet</div>
                @endforelse
            </ul>
        </x-menus.group>
        <x-menus.group groupname='Quick Searches'>
            <ul class="">
                <li><a href="{{ url('/') }}" class="hover:font-semibold no-underline">All works of Art</a></li>
                <li><a href="{{ url('/status/For Sale') }}" class="hover:font-semibold">Available for Sale</a></li>
                <li><a href="{{ url('/status/Sold') }}" class="hover:font-semibold">Sorry Sold Already</a></li>
                <li><a href="{{ url('/status/Not for Sale') }}" class="hover:font-semibold no-underline">Not for Sale</a></li>
                @guest
                <li class="hover:font-semibold"><a href="{{ url('login') }}"></i>Sign In</a></li>
                @endguest
            </ul>
        </x-menus.group>
        @auth
        <x-menus.group groupname='Admin'>
            <ul>
                <x-menus.item routename='dashboard'>Dashboard</x-menus.item>
                <x-menus.item routename='product.create'>Add New Item.</x-menus.item>
                <x-menus.item routename='messages'>Show Messages.</x-menus.item>
                <x-menus.item routename='category.index'>Categories.</x-menus.item>
            </ul>
            <a href="{{ route('logout') }}" class="hover:font-semibold no-underline" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                {{ csrf_field() }}
            </form>
        </x-menus.group>
        @endauth
    </div>