<Transition name="fade">
	<div v-if="showing" class="fixed inset-0 w-full h-screen flex items-center justify-center bg-semi-75"
		@click.self="closeModal" @keydown.esc="alert('1')">
		<div class="fixed inset-0 w-2/3 h-screen flex items-top justify-center text-white text-base font-light">
			<div class="relative w-screen max-w-2xl bg-white shadow-lg rounded-lg p-3 bg-modal-foreground">
				<div class="font-medium text-base text-white mt-6">MENU</div>

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



				<a href='#' onClick="alert('준비중입니다.');">
					<div class="flex items-center justify-between border-b-2 border-white ">
						<div class="text-white text-base font-light p-3 ">
							av토렌토</div>
						<div class="pr-3"> > </div>
					</div>
				</a>

				<a href='#' @click="dropdown1= !dropdown1">
					<div class="flex items-center justify-between border-b-2 border-white" 
						:class="dropdown1 ? 'text-orange-500' : 'text-white' ">
						<div class="text-base font-light p-3 ">
							고객센터 
						</div>
						<div v-if="! dropdown1" class="pr-3">
							+
						</div>
						<div v-if="dropdown1" class="pr-3">
							<svg class="w-4 h-4 fill-current text-white font-light text-orange-500 " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
								<path d="M7 10V2h6v8h5l-8 8-8-8h5z"/>
							</svg>
							</div>
					</div>
				</a>
				<div v-if="dropdown1" class="w-full bg-modal-gray-2 rounded-lg  "> 
						<a href="/customers?ccat_id=1"> <div class="text-base font-light py-3 px-5 border-b border-gray-100"> 1:1 문의 </div></a>
						<a href="/customers?ccat_id=2"> <div class="text-base font-light py-3 px-5 ">광고문의 </div></a>
				</div>


				<button aria-label="close" class="absolute top-0 right-0 text-xl text-gray-500 my-2 mx-4"
					@click.prevent="closeModal">
					×
				</button>
				<slot />
			</div>
		</div>
	</div>
</Transition>

<header>
	<div class="flex sm:hidden items-center justify-between p-0 top-menu-color py-1">
		<div class="flex-1 text-left" @click="showing=!showing">
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
		<div class="flex-1 text-left">

		</div>
		<div class="flex-1 ">
			<div class="text-center mx-auto">
				<a href="/">
					<img src="/images/go777.png" class="text-center mx-auto" width="200" height="75"
						alt="{{ env('APP_NAME')}} 메인" />
				</a>
			</div>
		</div>
		<div class="flex-1 text-center">
		</div>
	</div>

</header>


{{-- <div class=" flex flex-no-wrap text-xs font-medium text-black  text-center my-2 px-1 ">
		<div class="w-full flex-none whitespace-no-wrap overflow-x-auto">
				[{{ $item->cat->title }}]
{{ $item->title_short}}
</div>
</div> --}}

<div
	class=" sm:hidden flex flex-no-wrap  items-center justify-between font-700 w-full my-2 py-2 flex-none whitespace-no-wrap overflow-x-auto">
	<div class="flex-none ml-2  px-3  text-base {{ ! isset( $cat) && ! isset( $ccat)  ? 'text-red-600' : ''}}">
		<a href="/">메인</a>
	</div>
	@foreach($user_menus as $menu )
	@if( in_array( $menu['type'], ['dropdown', 'torrent','gallery']) )
	<div
		class="flex-none  px-2  text-base text-black {{ isset( $cat) && $cat->key == $menu['key'] ? 'text-red-600' : '' }} ">
		<a href="{{ $menu['link'] }}">{{ $menu['title'] }}</a>
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
	@if( in_array( $menu['type'], [ 'gallery']) )

	<div
		class=" px-2 py-3 mx-auto text-sm text-white  {{ isset( $cat) && $cat->key == $menu['key'] ? 'text-red-600' : '' }} ">
		<a href="{{ $menu['link'] }}" class="">{{ $menu['title'] }}</a>
	</div>


	@endif
	@endforeach
	<div class=" px-2 py-3 mx-auto text-sm text-white  {{ isset( $cat) && $cat->key == $menu['key'] ? 'text-red-600' : '' }} "
		@mouseover="openDropdown=!openDropdown" @click="goURL('/customers?ccat_id=1')">
		고객센터
	</div>

	<div v-if="openDropdown" class="relative mt-10 top-menu-color">

		<div class="absolute right-0 mt-0 py-1 w-48 top-menu-color rounded-xs shadow-xl">
			<a href="/customers?ccat_id=1"
				class="block px-4 py-1 text-sm font-light hover:font-semibold  hover:bg-blue-800 text-white hover:text-white">
				1:1 문의</a>
			<a href="/customers?ccat_id=2"
				class="block px-4 py-1 text-sm font-light hover:font-semibold hover:bg-blue-800 text-white hover:text-white">광고문의</a>
		</div>
	</div>


</div>