@extends('dashboard.base')

@section('content')


<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header"><h4>Menu Languages</h4></div>
            <div class="card-body">
                <div class="row">
                    <a class="btn btn-lg btn-primary" href="{{ route('languages.create') }}">Add new language</a>
                </div>
                <br>
                <table class="table table-striped table-bordered datatable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Short name</th>
                            <th>Is default</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($langs as $lang)
                            <tr>
                                <td>
                                    {{ $lang->name }}
                                </td>
                                <td>
                                    {{ $lang->short_name }}
                                </td>
                                <td>
                                    <?php 
                                        if($lang->is_default == true){
                                            echo 'YES';
                                        }else{
                                            echo 'NO';
                                        }
                                    ?>
                                </td>
                                <td>
                                    <a href="{{ route('languages.show', $lang->id ) }}" class="btn btn-primary">Show</a>
                                </td>
                                <td>
                                    <a href="{{ route('languages.edit', $lang->id ) }}" class="btn btn-primary">Edit</a>
                                </td>
                                <td>
                                <form action="{{ route('languages.destroy', $lang->id ) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button class="btn btn-danger">Delete</button>
                                </form>
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
  </div>
</div>

@endsection

@section('javascript')

@endsection