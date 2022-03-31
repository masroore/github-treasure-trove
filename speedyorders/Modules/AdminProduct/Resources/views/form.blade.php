<div class="" id="product-gallery">
</div>
<div class="panel-heading">
    <div class="row">
        <div class="col-md-3">
            <h5><strong>{{ ucfirst($action) ?? null }} Product</strong> </h5>
        </div>
        <div class="col-md-4 pull-right text-right">
            <button class="btn btn-success" type="submit">{{ $action == 'create' ? 'SAVE' : 'UPDATE' }}</button>
        </div>
    </div>
</div>
<div class="panel-body">

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#tab-1" aria-expanded="true"><strong>General Info</strong></a>
        </li>
        <li class=""><a data-toggle="tab" href="#tab-2" aria-expanded="false">Category</a></li>
        <li class=""><a data-toggle="tab" href="#tab-3" aria-expanded="false">Options</a></li>
        <li class=""><a data-toggle="tab" href="#tab-4" aria-expanded="false">Related Product</a></li>
        <li class=""><a data-toggle="tab" href="#tab-5" aria-expanded="false">Gallery</a></li>
        <li class=""><a data-toggle="tab" href="#tab-6" aria-expanded="false">Delivery Times</a></li>
    </ul>
    <br>

    <div class="tab-content">

        <div id="tab-1" class="tab-pane active">
            @include('adminproduct::forms.general')
        </div>

        <div id="tab-2" class="tab-pane product-category-tab">
            @include('adminproduct::forms.category')
        </div>

        <div id="tab-3" class="tab-pane">
            @include('adminproduct::forms.option')
        </div>

        <div id="tab-4" class="tab-pane">
            @include('adminproduct::forms.related_product')
        </div>
        <div id="tab-5" class="tab-pane">
            @include('adminproduct::forms.gallery')
        </div>
        <div id="tab-6" class="tab-pane">
            @include('adminproduct::forms.delivery_times')
        </div>

</div>

