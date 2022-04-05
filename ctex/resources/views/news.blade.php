@extends(Auth::user() ? 'layouts.dashboard' : 'layouts.app')

@section('title', trans('news.title'))

@section('content')
    <div class="container body-min-height">
        <!-- Page title -->
        <section id="page-title" class="page-title-left text-light background-dark">
            <div class="container">
                <div class="page-title">
                    <h1>{{ trans('news.page_title') }}</h1>
                    <span>{{ trans('news.page_title_desc') }}</span>
                </div>
            </div>
        </section>
        <!-- end: Page title -->
        <hr>
        <!-- Content -->
        <section id="page-content" class="dark">
            @csrf

            <div class="container" id="news_container">
            </div>
            <hr class="space">
            <!--
            <ul class="pagination justify-content-center">
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1"><i class="fa fa-angle-left"></i></a>
                </li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">4</a></li>
                <li class="page-item"><a class="page-link" href="#">5</a></li>
                <li class="page-item">
                    <a class="page-link" href="#"><i class="fa fa-angle-right"></i></a>
                </li>
            </ul>
            -->
        </section>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/moment.js') }}"></script>
    <script>
        $( document ).ready(function() {
            $('#top_news').addClass('text-danger');
            getNewsList(1);
        });

        function getNewsList(page) {
            var token = $("input[name=_token]").val();

            $.ajax({
                url: '{{ route('news.list') }}',
                type: 'POST',
                data: {_token: token, page: page},
                dataType: 'JSON',
                success: function (response) {
                    datas = new Array();
                    if (response == undefined || response.length == 0) {
                    } else {
                        var list_content = '';
                        for (var i = 0; i < response.length; i++) {
                            var content = '<div class="container" id="news_container">\n' +
                                '                <div class="form-group row news-item">\n' +
                                '                    <div class="col-lg-2 col-md-4 sub-date">' + moment(response[i].updated_at).utc().format('YYYY-MM-DD HH:mm:ss') + '</div>\n' +
                                '                    <div class="col-lg-10 col-md-8"><a class="font-size-md" href="{{url('news/detail')}}/' + response[i].id + '">' + response[i].title + '</a></div>\n' +
                                '                </div>\n' +
                                '            </div>';
                            list_content = list_content + content;
                        }

                        $('#news_container').html(list_content);
                    }
                }
            });
        }
    </script>
@endsection