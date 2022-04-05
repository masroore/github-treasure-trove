      <header class="c-header c-header-light c-header-fixed">
        <button class="c-header-toggler c-class-toggler d-lg-none mfe-auto" type="button" data-target="#sidebar" data-class="c-sidebar-show">
        <i class="bi bi-list"></i>
        </button><a class="c-header-brand d-lg-none c-header-brand-sm-up-center" href="#">
          EL OJO DE DIOS
          </a>
        <button class="c-header-toggler c-class-toggler mfs-3 d-md-down-none" type="button" data-target="#sidebar" data-class="c-sidebar-lg-show" responsive="true">
        <i class="bi bi-list"></i>
        </button>

        <ul class="c-header-nav mfs-auto">
         
        </ul>
        <ul class="c-header-nav">

          <li class="c-header-nav-item dropdown">
            <a class="c-header-nav-link">
              <i class="bi bi-person-fill mr-2"></i> {{Auth::user()->nombres}}
            </a>
          </li>
          <li class="c-header-nav-item dropdown">
          <a class="btn btn-sm btn-outline-danger mfe-md-3" href="{{route('logout')}}">
          Desconectar
          </a>
          </li>
        </ul>

      </header>