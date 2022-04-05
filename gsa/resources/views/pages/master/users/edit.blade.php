@extends('layouts.app')
@section('content')
<div class="card card-custom gutter-b example example-compact">
  <div class="card-header">
    <h3 class="card-title">FORM UBAH DATA USER LOGIN </h3>
  </div>
<form class="form" method="POST" 
    @if ($users->id == 0)
        action="{{url('master/users/save')}}"
    @else
        action="{{url('master/users/update')}}"
    @endif    
  >      
  <input type="hidden" name="id" value="{{ $users->id }}">
  {{ csrf_field() }}
  <div class="card-body">
    @if ($users->id == 0)
        <div class="alert alert-warning" role="alert">
            * Password default user login baru adalah <b>"qwerty"</b><br>
            * Password dapat dirubah saat login, pada menu account setting
        </div>
    @endif
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label>Nama User:</label>
                <input type="text" required class="form-control" name="nama" value="{{ $users->nama}}" />        
            </div>
            <div class="form-group">
                <label>Username User: <span class="d-none" id='warningusername' style='color:red; font-weight:bold;'>(username sudah digunakan)</span></label>
                <input type="text" 
                @if ($users->id > 0)
                    readonly style="background-color:#e4e4e4;"
                @endif
                required class="form-control" name="username" value="{{$users->username}}" id="username" />        
            </div>
            <div class="form-group">
                <label>No Telp User:</label>
                <input type="text" class="form-control" name="notelp" value="{{ $users->notelp}}" />        
            </div>
            <div class="form-group">
                <label>Alamat User:</label>
                <input type="text" class="form-control" name="alamat" value="{{ $users->alamat}}" />        
            </div>
            <div class="form-group">
                <label>Email User:</label>
                <input type="text" class="form-control" name="email" value="{{ $users->email}}" />        
            </div>
        </div>   
        <div class="col-lg-6">
            <div class="form-group">
                <label>Tipe Login:</label>
                <select class="custom-select" required  name="level" id="level">
                    <option value='' >Choose...</option>                    
                    <option value='1' @if($users->level == 1)selected @endif>Admin GSA</option>                    
                    <option value='5' @if($users->level == 5)selected @endif>Driver</option>                    
                    <option value='2' @if($users->level == 2)selected @endif>Customer </option>                    
                    <option value='3' @if($users->level == 3)selected @endif>Kantor Agen</option>                    
                    <option value='4' @if($users->level == 4)selected @endif>Kurir Delivery Agen</option>                    
                </select>        
            </div> 
            <div class="form-group " id='groupcustomer'>
                <label>Belongs to Customer:</label>
                <select class="custom-select"  name="id_customer" id="id_customer">
                    <option value='' >Choose...</option>
                    @foreach ($customer as $item)
                        <option 
                            @if($item->id == $users->id_customer)
                                selected
                            @endif
                            value="{{$item->id}}">{{$item->kode}} - {{$item->nama}}</option>
                    @endforeach
                </select>        
            </div> 
            <div class="form-group" id='groupagen'>
                <label>Belongs to Agen:</label>
                <select class="custom-select"  name="id_agen" id="id_agen">
                    <option value='' >Choose...</option>
                    @foreach ($agen as $item)
                        <option 
                            @if($item->id == $users->id_agen)
                                selected
                            @endif
                            value="{{$item->id}}">{{$item->kode}} - {{$item->nama}}</option>
                    @endforeach
                </select>        
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" @if($users->page_customer==1)checked="checked" @endif name="page_customer">
                <label class="form-check-label" for="page_customer">
                    Beri hak akses buka master Customer
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" @if($users->page_user==1)checked="checked" @endif name="page_user">
                <label class="form-check-label" for="page_user">
                    Beri hak akses buka master User
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" @if($users->page_agen==1)checked="checked" @endif name="page_agen">
                <label class="form-check-label" for="page_agen">
                    Beri hak akses buka master Agen
                </label>
            </div>
        </div>   
    </div>
  <div class="card-footer">
   <div class="row">
    <div class="col-lg-6">
     <button type="submit" id='simpanbutton' class="btn btn-primary mr-2">SIMPAN</button>
     @if ($users->id == 0)<button type="reset" class="btn btn-secondary">Cancel</button>@endif
    </div>
   </div>
  </div>
 </form>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/gsa/js/jquery-key-restrictions.js')}}"></script> 
<script type="text/javascript">
    $(document).ready(function() {

        checkhidden(0)
        $(function(){
            $("#username").alphaNumericOnly();
        });

        function checkhidden(resetval){
            if(resetval==1){
                console.log('masuk  ')
                $('#id_customer'    ).val(0)
                $('#id_agen'        ).val(0)        
                
                $("#id_customer").prop('required',false);
                $("#id_agen").prop('required',false);    
            }

            $('#groupcustomer'  ).removeClass('d-none')
            $('#groupagen'      ).removeClass('d-none')
            if($('#level').val()==5 ||$('#level').val()==1 || $('#level').val()==0 ){
                $('#groupcustomer').addClass('d-none')
                $('#groupagen'    ).addClass('d-none')
            }
            else if($('#level').val()==2 ){
                $('#groupagen').addClass('d-none')
                $("#id_customer").prop('required',true);
            }        
            else if($('#level').val()==3 || $('#level').val()==4 ){
                $('#groupcustomer').addClass('d-none')
                $("#id_agen").prop('required',true);
            } 
        }
        
        function checkusername() {
            $.ajax({
                method  :'GET',
                url     :'{{ url('master/users/checkusername') }}',
                data    :{
                    username:$('#username').val()
                },
                success:function(data){
                    if(data.username.length>0){
                        $('#username').css('background-color','#ffafaf')
                        $('#warningusername').removeClass("d-none")
                        $('#simpanbutton'   ).attr("disabled", true)
                    }else{
                        $('#username').css('background-color','white')
                        $('#warningusername').addClass("d-none")
                        $('#simpanbutton'   ).attr("disabled", false)
                    }
                }
            }) 
        }
        $("#level").change(function() {
            checkhidden(1)
        });
        $("#username").keyup(function() {
            @if($users->id == 0)
                clearTimeout(timertyping); 
                timertyping = setTimeout(checkusername, 1000)
            @endif
        });
    })
    
</script>
@endsection