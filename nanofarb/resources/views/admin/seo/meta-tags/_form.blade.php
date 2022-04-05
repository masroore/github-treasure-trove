<div class="row">
    <div class="col-lg-6">
        <div class="form-group {{ $errors->has('path') ? 'has-error' : ''}}">
            {!! Form::label('path', 'URL-path', ['class' => 'control-label',]) !!}
            {!! Form::text('path', empty($metaTag->path) ? null : url($metaTag->path), ['class' => 'form-control','placeholder' => 'Пример: http://google.com']) !!}
            {!! $errors->first('path', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
            {!! Form::label('title', 'Title', ['class' => 'control-label',]) !!}
            {!! Form::text('title', null, ['class' => 'form-control','placeholder' => '']) !!}
            {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
            {!! Form::label('description', 'Description', ['class' => 'control-label',]) !!}
            {!! Form::textarea('description', null, ['class' => 'form-control','placeholder' => '', 'rows' => 3]) !!}
            {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group {{ $errors->has('keywords') ? 'has-error' : ''}}">
            {!! Form::label('keywords', 'Keywords', ['class' => 'control-label',]) !!}
            {!! Form::textarea('keywords', null, ['class' => 'form-control','placeholder' => '', 'rows' => 3]) !!}
            {!! $errors->first('keywords', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group {{ $errors->has('seo_text') ? 'has-error' : ''}}">
            {!! Form::label('seo_text', 'SEO-text', ['class' => 'control-label',]) !!}
            {!! Form::textarea('seo_text', null, ['class' => 'form-control ck-editor ck-small','placeholder' => '', 'rows' => 5]) !!}
            {!! $errors->first('seo_text', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group {{ $errors->has('robots') ? 'has-error' : ''}}">
            {!! Form::label('robots', 'robots', ['class' => 'control-label',]) !!}
            {!! Form::text('robots', isset($metaTag) ? $metaTag->robots : null, ['class' => 'form-control','placeholder' => 'index,follow']) !!}
            {!! $errors->first('robots', '<p class="help-block">:message</p>') !!}
        </div>
        &nbsp;@include('admin.fields.field-select2-static', [
            'label' => 'priority',
            'field_name' => 'priority',
            'attributes' => array_combine(config('meta-tags.values.priority', []), config('meta-tags.values.priority', [])),
            'selected' => isset($metaTag) ? $metaTag->priority : variable('sitemap_priority', 0.5),
        ])
        @include('admin.fields.field-select2-static', [
            'label' => 'changefreq',
            'field_name' => 'changefreq',
            'attributes' => array_combine(config('meta-tags.values.changefreq', []), config('meta-tags.values.changefreq', [])),
            'selected' => isset($metaTag) ? $metaTag->changefreq : variable('sitemap_changefreq', 'daily'),
        ])
       {{--
        @include('admin.fields.field-image-uploaded-simple', [
            'label' => 'Изображение',
            'field_name' => 'og_image',
            'path' => isset($metaTag) && $metaTag->og_image ? '/'.$metaTag->og_image : null,
        ])
        --}}
    </div>
</div>

@include('admin.fields.field-form-buttons', [
    'url_store_and_create' => route('admin.meta-tags.create'),
    'url_store_and_close' => session('admin.meta-tags.index'),
    'url_destroy' => isset($metaTag) ? route('admin.meta-tags.destroy', $metaTag) : '',
    'url_after_destroy' => session('admin.meta-tags.index'),
    'url_close' => session('admin.meta-tags.index'),
])
