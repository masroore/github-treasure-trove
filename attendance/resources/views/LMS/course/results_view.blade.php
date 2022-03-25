@extends('LMS.course_layout')


@section('title')
OSMS | LMS | Start Quiz
@endsection

@section('mtitle')
Start Quiz
@endsection


@section('mtitlesub')

@endsection



@section('main_content')

<div class="row">
  <!-- left column -->
  <div class="col-md-7 offset-2">
    <!-- general form elements -->
    <div class="card">
      <div class="card-header">
        <div class="alert alert-info">Try Examination Results</div>
      </div>
      <div class="card-block">

        <?php
        $loops = 1; 
        ?>

        @foreach($examsresults as $results)
        <?php 
        $questions = App\Question::where('id',$results->question_id)
        ->with('qestionOptions')
        ->get();
        ?>
        @foreach($questions as $question)
        <b>Question &nbsp;  {{$loops}} &nbsp;::<br />
        {{$question['question']}}</b>

        @if($results->status == 'correct')
        <div class="form-group alert alert-success">
          @foreach($question->qestionOptions as $options)
          @if($options['id'] == $results->option_id)
          <div class="radio">
            <label>
              <input type="radio" name="ans{{$loops}}" id="optionsRadios1" value="{{$options['id']}}" checked>
              {{$options['option']}}
            </label>
          </div>

          @else

          <div class="radio">
            <label>
              <input type="radio" name="ans{{$loops}}" id="optionsRadios1" value="{{$options['id']}}" >
              {{$options['option']}}
            </label>
          </div>
          @endif
          @endforeach
        </div>
        @else
        <div class="form-group alert alert-danger">
          @foreach($question->qestionOptions as $options)
          @if($options['id'] == $results->option_id)
          <div class="radio">
            <label>
              <input type="radio" name="ans{{$loops}}" id="optionsRadios1" value="{{$options['id']}}" checked>
              {{$options['option']}}
            </label>
          </div>

          @else

          <div class="radio">
            <label>
              <input type="radio" name="ans{{$loops}}" id="optionsRadios1" value="{{$options['id']}}" >
              {{$options['option']}}
            </label>
          </div>
          @endif
          @endforeach
        </div>
        @endif  

        <b>Answer &nbsp; 
          {{$results->answer}}</b> <br><br>

          <hr>

          @endforeach
          <?php
          $loops++;
          ?>
          @endforeach

        </div>



      </div>
    </div>

  </div> 


  @endsection


  @section('style')
  
  @endsection


  @section('script')

  <script type="text/javascript">
    $('document').ready(function(){

      localStorage.removeItem("counter");

    });

  </script>
  @endsection