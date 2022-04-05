<form action="{{route('web.postSetAppointment',[$hospital->id])}}" method="POST">

    @csrf
    <input type="hidden" name="pacient_id" value="{{$userId}}">
    <input type="hidden" name="cart_id"
           value="{{$cartId}}">
    <input type="hidden" name="start_date">
    <input type="hidden" name="end_date">


    <div class="modal fade" id="modalAcceptAppointment" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-ce-soir" id="exampleModalCenterTitle">{{$hospital->name}} - Agendar
                        Cita</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">


                    <p class="font-campton text-ce-soir"></p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-ce-soir" id="acceptAppointment">
                        <i class="fas fa-check"></i> Aceptar
                    </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>

</form>