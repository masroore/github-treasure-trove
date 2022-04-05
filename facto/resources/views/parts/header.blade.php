<div x-data="leftmenu()" x-cloak>
	<div x-show.transition.in.duration.500ms.out.duration.500ms="show" 
		x-transition:enter="transition ease-out duration-1000"
		x-transition:enter-start="opacity-0 transform scale-90"
		x-transition:enter-end="opacity-100 transform scale-100"
		x-transition:leave="transition ease-in duration-1000"
		x-transition:leave-start="opacity-100 transform scale-100"
		x-transition:leave-end="opacity-0 transform scale-90"
		class="fixed inset-0 w-full h-screen flex items-center justify-center bg-semi-75"
	>
		<div class="fixed inset-0 w-6/12 h-screen flex items-top justify-center text-white text-base font-light">
			<div class="relative w-screen max-w-2xl bg-white shadow-lg rounded-lg p-3 bg-modal-foreground">
				<div class="font-medium text-base text-white mt-6">
					MENU
				</div>

				<div class="text-right p-1 flex items-center justify-around">
					@auth
						<a href="/profile" class="border border-blue-500 rounded-lg bg-green-500 text-white text-sm py-1 px-2 " >정보변경 </a> 
						<a href="/logout" class="border border-blue-500 rounded-lg bg-indigo-500 text-white text-sm py-1 px-2" >로그아웃</a> 
					@else 
						<a href="/login" class="border border-green-500 rounded-lg bg-green-500 text-white text-sm py-1 px-2" >로그인</a> 
					@endauth
				</div>


				<a href='/upsos'>
					<div class="flex items-center justify-between border-b-2 border-white ">
						<div class="text-white text-base font-light p-3 ">
							업소정보</div>
						<div class="pr-3"> > </div>
					</div>
				</a>
				<a href='/managers'>
					<div class="flex items-center justify-between border-b-2 border-white ">
						<div class="text-white text-base font-light p-3 ">
							매니저정보</div>
						<div class="pr-3"> > </div>
					</div>
				</a>

				<a href='/posts?cat_id=1'>
					<div class="flex items-center justify-between border-b-2 border-white ">
						<div class="text-white text-base font-light p-3 ">
							한국야동</div>
						<div class="pr-3"> > </div>
					</div>
				</a>


				<a href='/posts?cat_id=2'>
					<div class="flex items-center justify-between border-b-2 border-white ">
						<div class="text-white text-base font-light p-3 ">
							일본야동</div>
						<div class="pr-3"> > </div>
					</div>
				</a>


				<a href='/posts?cat_id=3'>
					<div class="flex items-center justify-between border-b-2 border-white ">
						<div class="text-white text-base font-light p-3 ">
							동양야동</div>
						<div class="pr-3"> > </div>
					</div>
				</a>

				<a href='/posts?cat_id=4'>
					<div class="flex items-center justify-between border-b-2 border-white ">
						<div class="text-white text-base font-light p-3 ">
							서양야동</div>
						<div class="pr-3"> > </div>
					</div>
				</a>



				<a href='https://yaburi01.com/posts-index/19' target='_blank'>
					<div class="flex items-center justify-between border-b-2 border-white ">
						<div class="text-white text-base font-light p-3 ">
							av토렌토</div>
						<div class="pr-3"> > </div>
					</div>
				</a>

				<a href='#' 
					
				>
					<div class="flex items-center justify-between border-b-2 border-white" 
						:class="{ 'text-orange-500' : dropdown1  ==true }"
						:class="{ 'text-white' : dropdown1 ==false } "
						
						>
						<div class="text-base font-light p-3 "
							x-on:click="toggleDropMenu2(1)"
						>
							고객센터 
						</div>
						<div x-show="! dropdown1" class="pr-3"
							x-on:click="toggleDropMenu2(1)"
						>
							+
						</div>
						<div x-show="dropdown1" class="pr-3"
							x-on:click="toggleDropMenu2(1)"
						>
							<svg class="w-4 h-4 fill-current text-white font-light text-orange-500 " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
								<path d="M7 10V2h6v8h5l-8 8-8-8h5z"/>
							</svg>
						</div>
					</div>
				</a>
				<div x-show="dropdown1" class="w-full bg-modal-gray-2 rounded-lg  "> 
						<a href="/customers?ccat_id=1"> <div class="text-base font-light py-3 px-5 border-b border-gray-100"> 1:1 문의 </div></a>
						<a href="/customers?ccat_id=2"> <div class="text-base font-light py-3 px-5 border-b border-gray-100">광고문의 </div></a>
						<a href="/customers?ccat_id=3"> <div class="text-base font-light py-3 px-5 ">업소제휴문의 </div></a>
				</div>
				<a href='#' 
				>
					<div class="flex items-center justify-between border-b-2 border-white" 
						:class="dropdown2 ? 'text-orange-500' : 'text-white' ">
						<div class="text-base font-light p-3 " 
							x-on:click="toggleDropMenu2(2)"
						>
							제휴사이트 
						</div>
						<div x-show="! dropdown2" class="pr-3"
							x-on:click="toggleDropMenu2(2)"
						>
							+
						</div>
						<div x-show="dropdown2" class="pr-3"
							x-on:click="toggleDropMenu2(2)"
						>
							<svg class="w-4 h-4 fill-current text-white font-light text-orange-500 " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
								<path d="M7 10V2h6v8h5l-8 8-8-8h5z"/>
							</svg>
						</div>
					</div>
				</a>
				<div x-show="dropdown2" class="w-full bg-modal-gray-2 rounded-lg  "> 
					<a href="https://www.mango17.me" target='_blank'>
						<div class="text-base font-light py-3 px-5 border-b border-gray-100"> 야동망고 </div>
					</a>
					{{-- <a href="http://moasso.com/" target='_blank'>
						<div class="text-base font-light py-3 px-5 border-b border-gray-100"> 모아쏘 </div>
					</a>
					<a href="https://www.linkmoon2.me?do=https://{{ request()->getHttpHost() }}/" target='_blank'>
						<div class="text-base font-light py-3 px-5 border-b border-gray-100"> 링크문 </div>
					</a> --}}

					<a href="https://noca52.com" target='_blank'>
						<div class="text-base font-light py-3 px-5 border-b border-gray-100"> 노카 </div>
					</a>
				</div>

				<button aria-label="close" 
					class="absolute top-0 right-0 text-2xl p-1 text-gray-500 bg-white rounded-full m-2 "
					x-on:click="close()"
					>
					<svg class="w-6 h-6 fill-current text-black rounded-full " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 8.586L2.929 1.515 1.515 2.929 8.586 10l-7.071 7.071 1.414 1.414L10 11.414l7.071 7.071 1.414-1.414L11.414 10l7.071-7.071-1.414-1.414L10 8.586z"/></svg>
				</button>
				{{-- <slot /> --}}
			</div>
		</div>
		<div class="fixed top-0 right-0 w-6/12 h-screen  "
			x-on:click="close()"
		>
			.
		</div>
	</div>

	@php
		$path = parse_url( request()->fullUrl())['path'] ?? '' ;
	@endphp
	<header>
		<div class="flex sm:hidden items-center justify-between p-0 top-menu-color py-1">
			<div class="flex-1 text-left" @click="show = ! show">
				<svg class="w-8 h-8 pl-2 font-black text-base fill-current white-white" xmlns="http://www.w3.org/2000/svg"
					viewBox="0 0 20 20">
					<path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" />
				</svg>
			</div>
			<div class="flex-1 ">
				<div class="text-center mx-auto">
					<a href="/"><img src="/images/go777.png" class="text-center mx-auto" width="150" height="50"
							alt="{{ env('APP_NAME')}} 메인" /></a>
				</div>
			</div>
			<div class="flex-1 text-center">
			</div>
		</div>


		<div class="hidden sm:block flex items-center justify-between mt-6 mb-4 p-0 bg-white ">
			<div class="flex items-center justify-between" >
				<div class="flex-1 text-left bg-red-300">
				</div>
				<div class="flex-1 ">
					<div class="text-center mx-auto">
						<a href="/">
							<img src="/images/go777.png" class="text-center mx-auto" width="200" height="75"
								alt="{{ env('APP_NAME')}} 메인" />
						</a>
					</div>
				</div>
				<div class="flex-1 text-right p-2 flex items-center justify-end">
					<div class="px-2 py-1">
						@auth
							<a href="/profile" class="border border-blue-500 rounded-lg bg-green-500 text-white text-sm py-1 px-2" >정보변경 </a> 
						@endauth
					</div>
					<div>
						@auth
							<a href="/logout" class="border border-blue-500 rounded-lg bg-indigo-500 text-white text-sm py-1 px-2" >로그아웃</a> 
						@else 
							<a href="/login" class="border border-green-500 rounded-lg bg-green-500 text-white text-sm py-1 px-2" >로그인</a> 
						@endauth
					</div>
				</div>
			</div>

		</div>

	</header>

	<div
		class=" sm:hidden flex flex-no-wrap  items-center justify-between font-700 w-full my-2 py-2 flex-none whitespace-no-wrap overflow-x-auto">
		<div class="flex-none ml-2  px-3  text-base {{ $path =='' ? 'text-red-600' : ''}}">
			<a href="/">메인</a>
		</div>
		@foreach($user_menus as $menu )
		@if( in_array( $menu['type'], ['dropdown','gallery', 'upso', 'manager']) )
			@if( Str::contains ( $path, '/' . $menu['key'])  )
				<div
					class="flex-none  px-2  text-base text-black text-red-600 }} ">
					<a href="{{ $menu['link'] }}">{{ $menu['title'] }}</a>
				</div>
			@else 
				<div
					class="flex-none  px-2  text-base text-black {{ isset( $cat) && $cat->key == $menu['key'] ? 'text-red-600' : '' }} ">
					<a href="{{ $menu['link'] }}">{{ $menu['title'] }}</a>
				</div>

			@endif 
		@elseif( in_array( $menu['type'], ['torrent']) )
		<div
			class="flex-none  px-2  text-base text-black {{ isset( $cat) && $cat->key == $menu['key'] ? 'text-red-600' : '' }} ">
			<a href="{{ $menu['link'] }}" target='_blank'>{{ $menu['title'] }}</a>
		</div>
		@endif
		@endforeach
	</div>



	<div class=" hidden  sm:block sm:flex items-center content-center  justify-between font-700 w-full my-2 top-menu-color">
		<div class=" px-4 py-3 text-sm text-white  top-menu-color-dark ">
			<svg class="fill-current text-white py-1 px-3 w-12 h-6 top-menu-color-dark" xmlns="http://www.w3.org/2000/svg"
				viewBox="0 0 20 20">
				<path d="M8 20H3V10H0L10 0l10 10h-3v10h-5v-6H8v6z" />
			</svg>
		</div>

		@foreach($user_menus as $menu )
		@if( in_array( $menu['type'], [ 'gallery', 'upso', 'manager']) )

			@if( $path =='/' . $menu['key']) 
				<div
					class=" px-2 py-3 mx-auto text-sm text-white text-red-600 }} ">
					<a href="{{ $menu['link'] }}" class="">{{ $menu['title'] }}</a>
				</div>

			@else 
				<div
					class=" px-2 py-3 mx-auto text-sm text-white  {{ isset( $cat) && $cat->key == $menu['key'] ? 'text-red-600' : '' }} ">

					<a href="{{ $menu['link'] }}" class="">{{ $menu['title'] }}</a>
				</div>


			@endif 
		@endif
		@endforeach

		<div class=" px-2 py-3 mx-auto text-sm text-white  {{ isset( $cat) && $cat->key == $menu['key'] ? 'text-red-600' : '' }} "
			x-on:click="toggleDropMenu(1)"
			x-on:mouseenter="mouseover(1, true)"
			x-on:mouseleave="mouseover(1, false)"
			{{-- // ; openDropdown=!openDropdown"  --}}
			@click="goURL('/customers?ccat_id=1')">
			고객센터
		</div>

		<div x-show="openDropdown1" 
			
			x-on:mouseenter="mouseover(1, true)"
			x-on:mouseleave="mouseover(1, false)"
		class="relative mt-10 top-menu-color">

			<div class="absolute right-0 mt-0 py-1 w-32 top-menu-color rounded-xs shadow-xl">
				<a href="/customers?ccat_id=1"
					class="block px-4 py-1 text-sm font-light hover:font-semibold  hover:bg-blue-800 text-white hover:text-white">
					1:1 문의</a>
				<a href="/customers?ccat_id=2"
					class="block px-4 py-1 text-sm font-light hover:font-semibold hover:bg-blue-800 text-white hover:text-white">광고문의</a>
				<a href="/customers?ccat_id=3"
					class="block px-4 py-1 text-sm font-light hover:font-semibold hover:bg-blue-800 text-white hover:text-white">업소제휴문의</a>					
			</div>
		</div>


		<div class=" px-2 py-3 mx-auto text-sm text-white  {{ isset( $cat) && $cat->key == $menu['key'] ? 'text-red-600' : '' }} "
			x-on:click="toggleDropMenu(2)"
			x-on:mouseenter="mouseover(2, true)"
			x-on:mouseleave="mouseover(2, false)"
			 {{-- ; openDropdown2=!openDropdown2"  --}}
			>
			제휴사이트
		</div>

		<div x-show="openDropdown2" 

			x-on:mouseenter="mouseover(2, true)"
			x-on:mouseleave="mouseover(2, false)"
			class="relative mt-10 top-menu-color">

			<div class="absolute right-0 mt-0 py-1 w-32 top-menu-color rounded-xs shadow-xl">
				<a href="https://www.mango17.me" target='_blank'
					class="block px-4 py-1 text-sm font-light hover:font-semibold  hover:bg-blue-800 text-white hover:text-white">
					야동망고
				</a>
				{{-- <a href="http://moasso.com/" target='_blank'
					class="block px-4 py-1 text-sm font-light hover:font-semibold  hover:bg-blue-800 text-white hover:text-white">
					모아쏘
				</a> --}}
				{{-- <a href="https://www.linkmoon2.me?do=https://{{ request()->getHttpHost() }}/" target='_blank'
					class="block px-4 py-1 text-sm font-light hover:font-semibold  hover:bg-blue-800 text-white hover:text-white">
					링크문
				</a> --}}
				<a href="https://noca52.com/" target='_blank'
					class="block px-4 py-1 text-sm font-light hover:font-semibold  hover:bg-blue-800 text-white hover:text-white">
					노카 
				</a>

			</div>
		</div>

	</div>
</div>

<script>
    function leftmenu() {
        return {
			show: false,
			dropdown1: false,
			dropdown2: false,
			openDropdown: false,
			openDropdown1: false,
			openDropdown2: false,
			mouseover( num, show){
				if( show == false && num == 1 ){
					this.openDropdown1 = false;
				} else if( show == false && num == 2 ){
					this.openDropdown2 = false;
				} else if( show == true && num == 1 ){
					this.openDropdown1 = true;
				} else if( show == true && num == 2 ){
					this.openDropdown2 = true;
				}
			},
			toggleDropMenu( num) {
				if( num == 1 ){
					this.openDropdown1 = ! this.openDropdown1 ;
				} else if( num == 2 ){
					this.openDropdown2 = ! this.openDropdown2 ;
				}
			},
			toggleDropMenu2( num) {
				console.log(num)
				if( num == 1 ){
					this.dropdown1 = ! this.dropdown1 ;
				} else if( num == 2 ){
					this.dropdown2 = ! this.dropdown2 ;
				}
			},
            open() { this.show = true },
            close() { 
				console.log('clp')
				this.show = false 
			},
            isOpen() { return this.show === true },
        }
    }
</script>
