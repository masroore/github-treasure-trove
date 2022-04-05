
<table class="table table-bordered table-hover table-striped">
  @foreach($properties->attributes as $key => $d)
    @if($key == 'password' || $key == 'remember_token')
    @else
    <tr>
      <td>{{ $key }}</td>
      <td>{{ $d }}</td>
    </tr>
    @endif
  @endforeach
</table>