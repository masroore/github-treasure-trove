<div class="modal  " id="modalpenerima"  data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
             
                <h5 class="modal-title" id="exampleModalLabel">Isi nama Penerima</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"> 
                @isset( $awbbelumditerima[0])
                    <div class="alert alert-danger" role="alert"> 
                        HARAP ISI NAMA PENERIMA! 
                        <br>Anda belum mengisi nama penerima
                        <BR>untuk kode awb <b style="font-size:15px;">{{$awbbelumditerima[0]->noawb}} </b>
                         
                    </div>
                    <input type="hidden" name="reload_penerima" id="reload_penerima" value="reload" />        
                @endif
                <input type="text" required class="form-control" name="diterima_oleh" id="diterima_oleh" value="" placeholder="diterima oleh(Nama Penerima)"/>        
                <textarea 
                    required 
                    class   = "form-control mt-5" 
                    name    = "keterangan_kendala" 
                    id      = "keterangan_kendala"  
                    rows    = "5"
                    placeholder="Keterangan kendala (alamat pindah, no hp tidak bisa dihubungi, dll)"/></textarea>
                <input type="hidden" required class="form-control" name="kodeawb_penerima" id="kodeawb_penerima" 
                        value="@isset( $awbbelumditerima[0]){{$awbbelumditerima[0]->noawb}}@endif" placeholder="diterima oleh"/>        
            </div>
            <div class="modal-footer">
                <button type="button" onclick="updatepenerima()" class="btn btn-success" >Simpan</button> 
            </div>
        </div>
    </div>
</div> 