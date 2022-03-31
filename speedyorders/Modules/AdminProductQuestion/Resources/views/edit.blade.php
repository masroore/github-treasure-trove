@extends('layouts.main')

@section('ext_css')

@endsection

@section('content')

<div class="row">
    <div class="col-md-9">
        <div class="boxed">
            <div class="boxed-wrapper">
            <div class="hpanel">
               <form method="POST" id="pq" action="{{ route('admin.product.questions.update',[$productquestion->id]) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-3">
                                <h5><strong> Edit Product Question</strong> </h5>
                            </div>
                            <div class="col-md-4 pull-right text-right">
                                <button class="btn btn-success" type="submit">Update</button>
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
                        @include ('adminproductquestion::form', ['formMode' => 'edit'])
                    </div>
                </form>
            </div>
            <div class="hpanel">
                <h4>Answers</h4>
                <div class="table-responsive">
                    <table id="productTable" class="table table-bordered table-striped speedy-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Answer</th>
                                <th>Answer date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($productQuestionanswers as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->answer }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>
                                        <button data-toggle="modal" data-target="#delete-modal"
                                            data-url="{{route('admin.product.questions.answer.destroy',$item->id)}}"
                                            class="btn btn-danger delete">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                            <tr>
                                <td class="text-center" colspan="6">
                                    <span>No data available in the table...</span>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <form method="POST" id="pqa" action="{{ route('admin.product.questions.answer',[$productquestion->id]) }}" accept-charset="UTF-8" class="form-horizontal">
                     @csrf
                     <div class="panel-heading">
                         <div class="row">
                             <div class="col-md-3">

                            </div>
                             <div class="col-md-4 pull-right text-right">
                                 <button class="btn btn-success" type="submit">Answer</button>
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

                         <div class="form-group {{ $errors->has('answer') ? 'has-error' : ''}}">
                            <label for="answer" class="control-label">{{ 'Answer' }}</label>
                            <textarea class="form-control" rows="5" name="answer" type="textarea" id="answer" required>{{ isset($productquestion->answer) ? $productquestion->answer : ''}}</textarea>
                            {!! $errors->first('answer', '<p class="help-block">:message</p>') !!}
                        </div>
                     </div>
                 </form>
             </div>
        </div>
    </div>
</div>
@endsection

@section('ext_js')


@endsection
