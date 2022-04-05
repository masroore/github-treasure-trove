<div class="row">
    <div class="col-lg-6">
        {{--
        <div class="form-group {{ $errors->has('url_alias') ? 'has-error' : ''}}">
            {!! Form::label('url_alias', 'URL-alias', ['class' => 'control-label',]) !!}
            {!! Form::text('url_alias', isset($model) && $model->urlAlias ? $model->urlAlias->alias : null, ['class' => 'form-control','placeholder' => '']) !!}
            {!! $errors->first('url_alias', '<p class="help-block">:message</p>') !!}
        </div>
        --}}
        <div class="form-group {{ $errors->has('meta_tag.title') ? 'has-error' : ''}}">
            {!! Form::label('meta_tag[title]', 'Title', ['class' => 'control-label',]) !!}
            {!! Form::text('meta_tag[title]', isset($model) && $model->metaTag ? $model->metaTag->title : null, ['class' => 'form-control','placeholder' => '']) !!}
            {!! $errors->first('meta_tag.title', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group {{ $errors->has('meta_tag.description') ? 'has-error' : ''}}">
            {!! Form::label('meta_tag[description]', 'Description', ['class' => 'control-label',]) !!}
            {!! Form::textarea('meta_tag[description]', isset($model) && $model->metaTag ? $model->metaTag->description : null, ['class' => 'form-control','placeholder' => '', 'rows' => 3]) !!}
            {!! $errors->first('meta_tag.description', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group {{ $errors->has('meta_tag.keywords') ? 'has-error' : ''}}">
            {!! Form::label('meta_tag[keywords]', 'Keywords', ['class' => 'control-label',]) !!}
            {!! Form::textarea('meta_tag[keywords]', isset($model) && $model->metaTag ? $model->metaTag->keywords : null, ['class' => 'form-control','placeholder' => '', 'rows' => 3]) !!}
            {!! $errors->first('meta_tag.keywords', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group {{ $errors->has('seo_text') ? 'has-error' : ''}}">
            {!! Form::label('meta_tag[seo_text]', 'SEO-text', ['class' => 'control-label',]) !!}
            {!! Form::textarea('meta_tag[seo_text]', isset($model) && $model->metaTag ? $model->metaTag->seo_text : null, ['class' => 'form-control ck-editor ck-small','placeholder' => '', 'rows' => 5]) !!}
            {!! $errors->first('meta_tag.seo_text', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group {{ $errors->has('meta_tag.robots') ? 'has-error' : ''}}">
            {!! Form::label('meta_tag[robots]', 'robots', ['class' => 'control-label',]) !!}
            {!! Form::text('meta_tag[robots]', isset($model) && $model->metaTag ? $model->metaTag->robots : null, ['class' => 'form-control','placeholder' => 'index,follow']) !!}
            {!! $errors->first('meta_tag.robots', '<p class="help-block">:message</p>') !!}
        </div>
        &nbsp;@include('admin.fields.field-select2-static', [
            'label' => 'priority',
            'field_name' => 'meta_tag[priority]',
            'attributes' => array_combine(config('meta-tags.values.priority', []), config('meta-tags.values.priority', [])),
            'selected' => isset($model) && $model->metaTag ? $model->metaTag->priority : variable('sitemap_priority', 0.5),
        ])
        @include('admin.fields.field-select2-static', [
            'label' => 'changefreq',
            'field_name' => 'meta_tag[changefreq]',
            'attributes' => array_combine(config('meta-tags.values.changefreq', []), config('meta-tags.values.changefreq', [])),
            'selected' => isset($model) && $model->metaTag ? $model->metaTag->changefreq : variable('sitemap_changefreq', 'daily'),
        ])
        {{--
        @include('admin.fields.field-image-uploaded-simple', [
            'label' => 'Изображение',
            'field_name' => 'og_image',
            'path' => isset($model) && $model->metaTag && $model->metaTag->og_image ? '/'.$model->metaTag->og_image : null,
        ])
        --}}
    </div>
</div>