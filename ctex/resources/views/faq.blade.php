@extends(Auth::user() ? 'layouts.dashboard' : 'layouts.app')

@section('title', trans('faq.title'))

@section('content')
    <div class="container body-min-height">
        <!-- Page title -->
        <section id="page-title" class="page-title-left text-light background-dark">
            <div class="container">
                <div class="page-title">
                    <h1>{{ trans('faq.page_title') }}</h1>
                    <span>{{ trans('faq.page_title_desc') }}</span>
                </div>
            </div>
        </section>
        <!-- end: Page title -->
        <hr>
        <!-- Content -->
        <section id="page-content" class="dark">
            @csrf

            <div class="container">
                <div class="form-group col-lg-6">
                    <select class="form-select text-light input-dark-bg" id="faq_category" onchange="changeCategory()">
                        @foreach($category_list as $category_info)
                            <option value="{{ $category_info['id'] }}" @if(isset($category_id) && $category_id == $category_info['id']) selected @endif>{{ $category_info['name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="toggle accordion dark" id="faq_list">
                    @foreach($faq_list as $faq_info)
                    <div class="ac-item">
                        <h5 class="ac-title"><span class="font-size-xl text-primary">{{ trans('faq.q') }}&nbsp;</span>{{ $faq_info['question'] }}</h5>
                        <div class="ac-content">
                            <p><span class="font-size-xl text-primary">{{ trans('faq.a') }}&nbsp;</span>{{ $faq_info['answer'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script>
        $( document ).ready(function() {
            $('#top_faq').addClass('text-danger');
        });

        function changeCategory()
        {
            var category_id = $('#faq_category').val();
            window.location.href = '{{ url('faq') }}/' + category_id;
        }
    </script>
@endsection