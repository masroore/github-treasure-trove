@extends('LMS.layout')


@section('title')
OSMS | LMS | PROFILE
@endsection

@section('mtitle')
OSMS LMS
@endsection


@section('mtitlesub')

@endsection



@section('main_content')

<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-header">
                <h5>Profile Image</h5>
            </div>
            <div class="card-block">
                <div style="margin: auto auto;">
                    <img class="img-responsive img-circle" src="{{asset('storage')}}/{{auth()->user()->pro_pic}}" width="100" height="100" alt="User profile picture" style="display: block; margin: auto;">
                </div>
                
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="card-header">
                <h5>Personnal Information</h5>
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
                        <tbody>

                            <tr>
                                <td>Fullname</td>
                                <td>{{$personal->fullname}}</td>

                            </tr>
                            <tr>
                                <td>Date of birth</td>
                                <td>{{$personal->dateofbirth}}</td>
                                
                            </tr>

                            <tr>
                                <td>Email</td>
                                <td>{{$personal->email}}</td>

                            </tr>
                            <tr>
                                <td>Phone</td>
                                <td>{{$personal->phone}}</td>

                            </tr>
                            <tr>
                              <td>Marital Status</td>
                              <td>{{$personal->maritalstutus}}</td>

                          </tr>
                      </tbody>
                  </table>
              </div>
          </div>
      </div>

      <div class="card">
        <div class="card">
            <div class="card-header">
                <h5>Academic Information</h5>
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
                        <tbody>
                            <tr>

                                <td>Entry Level</td>
                                <td>{{$personal->entrylevel}}</td>
                            </tr>
                            <tr>

                                <td>Current Level</td>
                                <td>{{$personal->currentlevel}}</td>
                            </tr>

                            <tr>

                                <td>Programme</td>
                                <td>{{$personal->programme}}</td>
                            </tr>
                            <tr>

                                <td>Session</td>
                                <td>{{$personal->session}}</td>
                            </tr>
                            <tr>

                                <td>Index Number</td>
                                <td>{{$personal->indexnumber}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>



        <div class="card">
            <div class="card">
                <div class="card-header">
                    <h5>Guidian Infomation</h5>
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
                            <tbody>
                                <tr>
                                    <td>Guidian Fullname</td>
                                    <td>{{$personal->gurdianname}}</td>
                                </tr>
                                <tr>
                                    <td>Relationship</td>
                                    <td>{{$personal->relationship}}</td>
                                </tr>

                                <tr>
                                    <td>Occupation</td>
                                    <td>{{$personal->occupation}}</td>

                                </tr>
                                <tr>
                                    <td>Phone</td>
                                    <td>{{$personal->mobile}}</td>

                                </tr>
                            </tbody>
                        </table>
                    </div>
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