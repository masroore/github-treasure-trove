<!-- navigation -->
		@if(!Session::has('id'))
			<script>
			// your "Imaginary javascript"
			 // window.location.href = '{{url("yoururl")}}';
			// or
			 window.location.href = '{{route("online-admission-login")}}'; //using a named route
			</script>
		@endif
		<div class="navigation-w3ls">
			<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-nav">
				<button class="navbar-toggler mx-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
				 aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse text-center" id="navbarSupportedContent">
					<ul class="navbar-nav justify-content-center">
						<li class="nav-item
									@if(Route::current()->getName() == 'admission-personal-info' )
										active									
									@endif ">
							<a class="nav-link text-white" href="{{ route('admission-personal-info') }}">Personal Information
								<span class="sr-only">
									(current)
								</span>
							</a>
						</li>
						<li class="nav-item
							@if(Route::current()->getName() == 'admission-personal-results' )
										active									
									@endif
						">
							<a class="nav-link text-white" href="{{route('admission-personal-results')}}">Results</a>
						</li>
						<li class="nav-item
							@if(Route::current()->getName() == 'admission-personal-school' )
										active									
									@endif
						">
							<a class="nav-link text-white" href="{{ route('admission-personal-school')}}">Schools Attended</a>
						</li>
						<li class="nav-item 
							@if(Route::current()->getName() == 'admission-app-info' )
										active									
									@endif
						">
							<a class="nav-link text-white" href="{{ route('admission-app-info')}}">Application Information</a>
						</li>
						<li class="nav-item 
							@if(Route::current()->getName() == 'admission-guidian-info' )
										active									
									@endif
						">
							<a class="nav-link text-white" href="{{route('admission-guidian-info')}}">Guardian Information</a>
						</li>
						<li class="nav-item 
							@if(Route::current()->getName() == 'admission-sup-doc' )
										active									
									@endif
						">
							<a class="nav-link text-white" href="{{route('admission-sup-doc')}}">Suppoting Documnents</a>
						</li>
						<li class="nav-item 
							@if(Route::current()->getName() == 'admission-prof-img' )
										active									
									@endif
						">
							<a class="nav-link text-white" href="{{route('admission-prof-img')}}">Profile Image</a>
						</li>

					</ul>
				</div>
			</nav>
		</div>
		<!-- //navigation -->