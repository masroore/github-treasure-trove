@extends('LMS.layout')


@section('title')
OSMS | LMS | MAIN
@endsection

@section('mtitle')
OSMS LMS
@endsection


@section('mtitlesub')

@endsection



@section('main_content')

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Title</h5>
            </div>
            <div class="card-block">
                <form class="form-material">

                    <div class="form-group  @error('name') form-danger @enderror form-static-label">
                        <input type="text" name="" id="" value="{{old('name')}}" class="form-control">
                        <span class="form-bar"></span>
                        <label class="float-label">form-title</label>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">

            <div class="card">
                <div class="card-header">
                    <h5>Table Title</h5>
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
                                    <th>#</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Username</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Mark</td>
                                    <td>Otto</td>
                                    <td>@mdo</td>
                                </tr>
                                
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