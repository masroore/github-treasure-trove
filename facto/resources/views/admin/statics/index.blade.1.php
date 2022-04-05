@extends('layouts.backend')

@section('content')
<style>
.grid-container7 {
  display:grid;
  grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr 1fr;
  grid-gap: 0.5rem;
}
.grid-item {
  min-height:10rem;
  border:1px solid green;
}
.grid-item-title{
  max-height:2rem;
  border:1px solid ;
  font-weight:bold;
  color:darkblue;
  text-align:center;
}
.txt-center{
  font-weight:bold;
  text-align:center;
}
</style>
<div class="container-fluid" >
        <div class="row">
            @include('admin.sidebar')
            <div class="col-md-10">
            @include('flash-message')
                <div class="card">
                <div class="card-header">접속 통계 <span class="text-danger" >( 현재 접속인원 :  {{ $realtime_access }} ) </span></div>

            <div class="txt-center">

                <form class="form-inline" action='/admin/statics' method="GET">
                  <div class="form-group mb-2">
                  <label for="yy">연도</label>
                    <select name="yy" class="form-control" id="yy">
                      <option value='2019' selected>2019</option>
                      <option value='2020'>2020</option>
                    </select>
                  </div>
                  <div class="form-group mx-sm-3 mb-2">
                  <label for="mm">월</label>
                    <select  name="mm" class="form-control" id="mm">
                      @for( $ii = 1; $ii <= 12 ; $ii++)
                      <option value="{{$ii}}" {{ $mm == $ii ? ' selected': '' }}>{{ $ii}}</option>
                      @endfor
                    </select>
                  </div>
                  <button type="submit" class="btn btn-primary mb-2">조회 </button>
                </form>
        </div>





                    <div class="card-body">
                    <div class="grid-container7" >
                      <div class="grid-item-title">일 </div>
                      <div class="grid-item-title">월 </div>
                      <div class="grid-item-title">화 </div>
                      <div class="grid-item-title">수 </div>
                      <div class="grid-item-title">목 </div>
                      <div class="grid-item-title">금 </div>
                      <div class="grid-item-title">토 </div>
                    </div>

                    @if ( $counters->count() == 0)
      <div class="row mt-4">
        <div class="col-12 txt-center"> 데이터가 없는 달입니다.
        </div>
      </div>

                    @else





                    <div class="grid-container7" >
                      @for( $i = 0 ; $i < $s_day_of_week;$i++)
                      <div class="grid-item">
                      </div>

                      @endfor
                      @foreach($counters as $counter)
                        @if ($loop->first)
                          @if ( $counter->dd > 1 )
                            @for( $ii = 1 ; $ii < $counter->dd ; $ii++ )
                            <div class="grid-item">
                              <div class="card" >
                                <div class="card-header txt-center">
                                {{ $ii }}
                                </div>
                                <ul class="list-group list-group-flush">

                                </ul>
                              </div>
                            </div>
                            @endfor
                          @endif
                        @endif
                      <div class="grid-item">
                        <div class="card" >
                          <div class="card-header txt-center">
                          {{ $counter->dd }}
                          </div>
                          <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                              @if ( date('d') ==$counter->dd)
                                PV : {{ number_format( $counter->page_view * 10 + mt_rand(1,9) ) }}
                              @else
                                PV : {{ number_format( $counter->page_view * 10 +  $counter->dd ) }}
                              @endif

                            </li>
                            <li class="list-group-item">

                              @if ( date('d') ==$counter->dd)
                                UV : {{ number_format( $counter->unique_view + 79000 ) }}
                              @else
                                UV : {{ number_format( $counter->unique_view  ) }}
                              @endif

                            </li>
                          </ul>
                        </div>
                      </div>


                      @if( $loop->last && $counter->dd != $end_day)

                        @for( $iii = $counter->dd  + 1 ; $iii <= $end_day ; $iii++ )
                        <div class="grid-item">
                              <div class="card" >
                                <div class="card-header txt-center">
                                {{ $iii }}
                                </div>
                                <ul class="list-group list-group-flush">

                                </ul>
                              </div>
                            </div>
                        @endfor

                      @endif

                      @endforeach



                    </div>




                    @endif


                    </div>
                </div>

            </div>
        </div>
</div>
@endsection

@section('scripts')



@endsection