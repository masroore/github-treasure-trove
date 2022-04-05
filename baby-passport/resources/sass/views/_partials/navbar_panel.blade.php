<nav class="navbar navbar-expand-lg navbar-dark bg-ce-soir py-3 ">
    <a class="navbar-brand" href="#">
        <img src="{{asset("img/logos/logo-ffffff.png")}}" alt="" class="logo">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">

            <!-- ICON -->
            <li class="nav-item dropdown">

                <a class="btn btn-white text-light dropdown-toggle" href="#" id="notifications-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i id="notificationsIcon" class="fa fa-bell-o" aria-hidden="true"></i>
                    <span id="notificationsBadge" class="badge badge-danger">0</span>
                </a>

                <div class="dropdown-menu notification-dropdown-menu p-2" aria-labelledby="notifications-dropdown">
                    <h6 class="dropdown-header">Notificaciones</h6>


                    <div id="notificationsContainer" class="notifications-container">


                    </div>




                </div>

            </li>

            <li class="nav-item ">
                <a class="nav-link " href="{{route('users.index')}}">Usuarios</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link " href="{{route('cities.index')}}">Ciudades</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('products.index')}}">Productos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('ratings.index')}}">Ratings</a>
            </li>


            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    Configuración Blog
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{route('categories.index')}}">Categorías</a>
                    <a class="dropdown-item" href="{{route('tags.index')}}">Etiquetas</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{route('blogs.index')}}">Blogs</a>
                </div>
            </li>


            <audio src="{{asset('sounds/msn.mp3')}}" id="notificationSound"></audio>

            {{--notification --}}
            <notification :unreads="[]"></notification>


        </ul>

        <ul class="navbar-nav">


            <li class="nav-item">
                <a class="nav-link text-light"
                   href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-power-off"></i> Cerrar Sesión
                </a>

                <form id="logout-form"
                      action="{{ route('logout') }}"
                      method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        </ul>


    </div>
</nav>