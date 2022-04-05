{{-- This Partial forms the dropdown for the menu (nav.blade.php) item Our Program
      written using Tailwind Css. --}}
    <div class="relative group">
      <div class="ml-4 flex items-center cursor-pointer py-1">
        <div class=" p-2 text-pink text-xl font-semibold no-underline">
            <span>{{ Auth::user()->name }}</span>
         </div>
      </div>
      <div class="items-center absolute border border-t-0 bg-white invisible group-hover:visible">
              <ul class="list-reset">
                <li><a href="{{ url('/home') }}" class="no-underline text-lg font-semibold px-4 py-2 block text-black hover:bg-grey-light">Dashboard</a></li>
                <li><a href="{{ url('/program/nutrition') }}" class="no-underline text-lg font-semibold px-4 py-2 block text-black hover:bg-grey-light">Profile</a></li>
                <li> <a href="{{ route('logout') }}"
                     class="no-underline text-lg font-semibold px-4 py-2 block text-black hover:bg-grey-light"
                     onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                     <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    {{ csrf_field() }}
                    </form>
                  </li>
              </ul>
      </div>
    </div>
