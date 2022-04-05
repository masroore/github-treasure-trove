<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">

<div class="c-sidebar-brand d-md-down-none py-3">
       <a href="{{route('home')}}"><img src="/images/logo.png" alt="" class="img-fluid"></a> 
</div>

<ul class="c-sidebar-nav">
<li class="c-sidebar-nav-title">Estadistica</li>


<li class="c-sidebar-nav-title">Registro de denuncias</li>


 <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('casos')}}">
 <i class="bi bi-archive pr-2"></i> Casos</a></li>

 <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('personas')}}">
 <i class="bi bi-person pr-2"></i> Personas</a></li>


 <li class="c-sidebar-nav-title">Búsqueda</li>

 <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('telefonos')}}">
 <i class="bi bi-search pr-2"></i>  Telefonos</a></li>
 
 <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('correos')}}">
 <i class="bi bi-search pr-2"></i> Correos electronicos</a></li>
       
 <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('cuentas-bancarias')}}">
 <i class="bi bi-search pr-2"></i>  Cuentas Bancarias</a></li>

 <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('tarjetas')}}">
 <i class="bi bi-search pr-2"></i>  Tarjetas de Debito/Credito</a></li>

 <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('paginas-web')}}">
 <i class="bi bi-search pr-2"></i> Paginas Web</a></li>

 <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('redes-sociales')}}">
 <i class="bi bi-search pr-2"></i> Redes sociales</a></li>

 <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('imagenes')}}">
 <i class="bi bi-search pr-2"></i> Galeria de imagenes</a></li>



 <li class="c-sidebar-nav-title"><i class="bi bi-file-earmark-text  pr-2"></i> Documentos</li>

 <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="">
 <i class="bi bi-person pr-2"></i> Oficios</a></li>

 <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="">
 <i class="bi bi-person pr-2"></i> Informes de Inv.</a></li>


<li class="c-sidebar-nav-title">Consultas</li>
@can('Estadistica')        
<li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('home')}}">
<svg class="c-sidebar-nav-icon">
  <use xlink:href="node_modules/@coreui/icons/sprites/free.svg#cil-pencil"></use>
</svg> Estadistica</a></li>
@endcan
@can('Claro')        
        <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('claro')}}">
        <i class="bi bi-phone pr-2"></i> Consultas Claro</a></li>
@endcan
@can('Movistar')    
        <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('movistar')}}">
        <i class="bi bi-phone pr-2"></i> Consultas Movistar</a></li>
@endcan
@can('Entel')  
        <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('entel')}}">
        <i class="bi bi-phone pr-2"></i> Consultas Entel</a></li>
@endcan   
@can('Reniec')  
        <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('reniec')}}">
        <i class="bi bi-phone pr-2"></i> Consultas Reniec</a></li>
@endcan     
@can('Email')  
        <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('email')}}">
        <i class="bi bi-mailbox pr-2"></i> Consultas Email</a></li>
@endcan   
@can('Sistema')
        <li class="c-sidebar-nav-title">Sistema</li>
        <li class="c-sidebar-nav-item">
          <a class="c-sidebar-nav-link" href="{{route('users')}}">
          <i class="bi bi-gear pr-2"></i> Usuarios</a>
        </li>
        <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('permisos')}}">
        <i class="bi bi-gear pr-2"></i> Permisos</a></li>

        <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('user_activity')}}">
        <i class="bi bi-gear pr-2"></i> Actividades</a></li>
@endcan
        </ul>
        
        
        </div>
      </div>
    </div>