@extends('LMS.course_layout')


@section('title')
OSMS | LMS | E-Learning
@endsection

@section('mtitle')
 E-Learning
@endsection


@section('mtitlesub')

@endsection



@section('main_content')

<div class="row">
    <div class="col-md-8">

        <div style="background-color: #000;padding-top: 20px; padding-bottom: 20px; padding-left: 10px;">
        <div id="youtubevideo">
            <iframe width="720" height="400" 
                src="https://www.youtube.com/embed/{{$first->youtubeid}}"
                frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
        <h6 class="text-left" style="color: white;" id="week">{{$first->week}}</h6>
        <h6 class="text-left" style="color: white;" id="title">{{$first->title}}</h6>
        <p class="text-left" style="color: white;" id="desc">{{$first->desc}}</p>
        </div>
    </div>
    <div class="col-md-4" style="padding: 10px;">
        
        <div class="card table-card">
            <div class="card-header">
                <h5>Playlist</h5>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="fa fa fa-wrench open-card-option"></i></li>
                        <li><i class="fa fa-window-maximize full-card"></i></li>
                        <li><i class="fa fa-minus minimize-card"></i></li>
                        <li><i class="fa fa-refresh reload-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-block">
                <div class="table-responsive">
                    <table class="table table-hover m-b-0 without-header">
                        <tbody>

                            @foreach ($data as $row)
                            
                               <tr>
                                <td>
                                    <a href="#" class="getplaylistid" cid="{{$row->youtubeid}}" data-week="{{$row->week}}" data-title="{{$row->title}}" data-desc="{{$row->desc}}">

                                        <div class="d-inline-block align-middle">
                                            <img src="{{URL::to('images/youtubev.png')}}" alt="user image" class="img-radius img-40 align-top m-r-15">
                                            
                                        </div>
                                    </a>
                                </td>
                                <td class="text-left">
                                    <a href="#" class="getplaylistid" cid="{{$row->youtubeid}}" data-week="{{$row->week}}" data-title="{{$row->title}}" data-desc="{{$row->desc}}">

                                    <div class="d-inline-block">
                                            <h6>{{$row->week}}</h6>
                                            <h6>{{$row->title}}</h6>
                                            <p class="text-muted m-b-0">
                                                {{$row->desc}}
                                            </p>
                                            
                                        </div>
                                    </a>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    </div>
</div>



@endsection



@section('script')

<script type="text/javascript">

    $(document).ready(function(){

        $(document).on("click",".getplaylistid",function(e){
            e.preventDefault();
            var cid = $(this).attr("cid");
            var desc = $(this).data('desc');
            var week = $(this).data('week');
            var title = $(this).data('title');

            $("#week").text(week);
            $("#title").text(title);
            $("#desc").text(desc);
            loadvideo(cid);
        });

        //loadvideo(id);

        function loadvideo(id){

            $("#youtubevideo").html(`
                <iframe width="830" height="400" 
                src="https://www.youtube.com/embed/`+id+`"
                frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                `);
        }

    });

</script>


@endsection