@extends('LMS.layout')


@section('title')
OSMS | LMS | Private Files
@endsection

@section('mtitle')

Private Files

@endsection


@section('mtitlesub')

@endsection



@section('main_content')

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Upload Files</h5>
            </div>
            <div class="card-block">
                <form class="form-material" method="post" enctype="multipart/form-data" action="{{ route('lms-private-file-save') }}">
                    @csrf

                    <div class="form-group  @error('title') form-danger @enderror form-static-label">
                        <input type="text" name="title" id="title" value="{{old('title')}}" class="form-control">
                        <span class="form-bar"></span>
                        <label class="float-label">

                            @error('title')
                            {{ $message }}

                            @else
                            file title
                            @enderror 

                        </label>
                    </div>

                    <div class="form-group  @error('file') form-danger @enderror form-static-label">
                        <input type="file" name="file" id="file" value="{{old('file')}}" class="form-control" style="margin-top: 10px;">
                        <span class="form-bar"></span>
                        <label class="float-label">@error('file')
                         {{ $message }}

                         @else
                         Document
                     @enderror </label>
                 </div>


                 <input type="submit" name="submit" value="Upload" class="btn btn-info">

             </form>
         </div>
     </div>
 </div>
 <div class="col-md-6">
    <div class="card">

        <div class="card">
            <div class="card-header">
                <h5>Your Files</h5>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="fa fa fa-wrench open-card-option"></i></li>
                        <li><i class="fa fa-window-maximize full-card"></i></li>
                        <li><i class="fa fa-minus minimize-card"></i></li>
                        <li><i class="fa fa-refresh reload-card"></i></li>
                        <li><i class="fa fa-trash close-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-block table-border-style">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Title</th>
                                <th>Document</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($data as $row)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$row->title}}</td>
                                <td>
                                    <a href="{{asset('storage')}}/{{$row->file}}" target="_blank" class="btn btn-success"><span class="fa fa-download"></span></a>
                                </td>
                                <td>
                                    <a href="#" onclick="if(confirm('Are You Sure ?')){ event.preventDefault(); document.getElementById('delete_doc_{{$row->id}}').submit(); }" class="btn btn-danger"><i class='fa fa-trash'></i></a>
                                    <form id="delete_doc_{{$row->id}}" 
                                        action="{{ route('lms-private-file-delete', ['id'=> $row->id ]) }}" method="POST" style="display: none;">

                                        @csrf
                                    </form>

                                </td>
                            </tr>
                            @empty
                      <div class="alert alert-danger">
                        <h4>oowp!</h4>
                        <p>There are currently no File(s) Uploaded Yet.</p>
                      </div>

                    @endforelse


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>



@endsection



@section('script')

<script type="text/javascript">

</script>


@endsection