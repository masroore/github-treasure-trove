<div class="alert alert-warning alert-dismissible no-margin">
    <h4><i class="icon fa fa-warning"></i> {!! $msg_title ?? 'Контент не создан!' !!}</h4>
    @isset($msg_body){!! $msg_body  !!} @else Рекомендуем создать материал @endisset
    @isset($url_create)
        <a href="{{ $url_create }}" class="btn btn-xs btn-success">
            <i class="fa fa-plus"></i>
        </a>
    @endisset
</div>

{{--
@include('admin.fields.empty-rows', [
    //'url_create' => route('admin.users.create'),
    'msg_title' => 'Поиск не дал результатов',
    'msg_body' => 'Измените поисковый запрос, и попробуйте снова',
])
--}}