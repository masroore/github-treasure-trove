<div class="row">
  <div class="col-md-6">
    
    <table class="table table-bordered table-hover table-striped">
      <tr>
        <th colspan="2" class="text-center">DATA SEMULA</th>
      </tr>
      @foreach($data_old as $key => $d)
        @if($key == 'password' || $key == 'remember_token')
        @else
        <tr>
          <td>{{ $key }}</td>
          <td>{{ $d }}</td>
        </tr>
        @endif
      @endforeach
    </table>
  </div>
  <div class="col-md-6">
    
    <table class="table table-bordered table-hover table-striped">
      <tr>
        <th colspan="2" class="text-center">DATA MENJADI</th>
      </tr>
      @foreach($data_new as $key => $d)
      @if($key == 'password' || $key == 'remember_token')
      @else
      <tr>
        <td>{{ $key }}</td>
        <td>{{ $d }}</td>
      </tr>
      @endif
      @endforeach
    </table>
  </div>
</div>