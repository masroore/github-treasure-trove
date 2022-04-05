@extends('dashboard.base')

@section('css')
    <link href="{{ asset('css/dataTables.bootstrap4.css') }}" rel="stylesheet">
@endsection

@section('content')


        <div class="container-fluid">
            <div class="fade-in">
              <div class="card">
                <div class="card-header"> TwitterTables
                  <div class="card-header-actions"><a class="card-header-action" href="https://datatables.net" target="_blank"><small class="text-muted">docs</small></a></div>
                </div>
                <div class="card-body">
                  <table class="table table-striped table-bordered datatable" id="tabla">
                    <thead>
                      <tr>
                      <th width="50px">No</th>
                      <th>Twitter Id</th>
                      <th>Message</th>
                      <th>Images</th> 
                      <th>Favorite</th>
                      <th>Retweet</th>
                      </tr>
                    </thead>
                      <tbody>
                        @if(!empty($data))
                          @foreach($data['data']['statuses'] as $llave => $valor)
                            <tr>
                              <td>{{ ++$llave }}</td>
                              <td>{{ $valor['id_str'] }}</td>
                              <td>{{ $valor['full_text'] }}</td>
                              <td>
                                  @if(isset($valor['extended_entities']['media']))
                                      @foreach($valor['extended_entities']['media'] as $v)
                                          <img src="{{ $v['media_url_https'] }}" style="width:100px;">
                                      @endforeach
                                  @else
                                  Sin Imagen
                                  @endif
                              </td>
                              <td>{{ $valor['favorite_count'] }}</td>
                              <td>{{ $valor['retweet_count'] }}</td>
                            </tr>
                          @endforeach
                        @else
                          @if(!empty($tweetsNS))
                            @foreach ($tweetsNS as $item)
                              <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->id_tweet }}</td>
                                <td>{{ $item->tweet }}</td>
                                <td> 
                                @if($item->url_imagen!="Sin imagen")
                                <img src="{{ $item->url_imagen}}" style="width:100px;"></td>
                                @else
                                {{ $item->url_imagen }}</td>
                                @endif
                                <td>{{ $item->fav }}</td>
                                <td>{{ $item->rt }}</td>
                              </tr>
                            @endforeach
                          @else
                            <td colspan="6">No hay datos para mostrar.</td>
                          @endif
                          </tr>
                        @endif
                  </tbody>               
                  </table>
                </div>
              </div>
            </div>
          </div>

@endsection

@section('javascript')
    <script src="{{ asset('js/jquery.slim.min.js') }}"></script>
    <script src="{{ asset('js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/datatables.js') }}"></script>

    <script src="{{ asset('js/exportButtonExcel.js') }}"></script>

    <script src="{{ asset('datatables/Buttons-1.5.6/js/dataTables.buttons.min.js') }}"></script>  
    <script src="{{ asset('datatables/JSZip-2.5.0/jszip.min.js') }}"></script>    
    <script src="{{ asset('datatables/pdfmake-0.1.36/pdfmake.min.js') }}"></script>    
    <script src="{{ asset('datatables/pdfmake-0.1.36/vfs_fonts.js') }}"></script>
    <script src="{{ asset('datatables/Buttons-1.5.6/js/buttons.html5.min.js') }}"></script>

@endsection
