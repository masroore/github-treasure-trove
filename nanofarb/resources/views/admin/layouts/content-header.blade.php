<section class="content-header">
    <h1>
        @if(! empty($url_back))
            <a href="{{ $url_back }}" class="btn btn-xs btn-warning"><i class="fa fa-chevron-left"></i> Назад</a>
        @endif
        {!! $page_title ?? '' !!}
        <small>{{ $small_page_title ?? '' }}</small>
        @if(! empty($url_create))
            <a href="{{ $url_create }}" class="btn btn-xs btn-success"><i class="fa fa-plus"></i> Создать</a>
        @endif
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Главная</a></li>
        @isset($page_title)
        <li class="active">{{ $page_title }}</li>
        @endisset
    </ol>
</section>