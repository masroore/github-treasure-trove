<div class="modal-dialog  modal-dialog-centered">
    <div class="modal-content">
        @php
            $form_id = 'workspace_add_form';
            if(isset($quick_add)){
            $form_id = 'quick_add_workspace';
            }
        @endphp
        {!! Form::open(['url' => route('workspaces.store'), 'method' => 'post', 'id' => $form_id, 'files' =>true ]) !!}
        <div class="modal-header">
            <h4 class="modal-title">{{ __('project::workspace.Create Your Workspace') }}</h4>
            <button type="button" class="close " data-dismiss="modal">
                <i class="ti-close "></i>
            </button>
        </div>

        <div class="modal-body">
                    <div class="row">

                        @includeIf('project::workspaces.form.create-edit')

                    </div>
                </div>
        {!! Form::close() !!}
    </div>
</div>


<script>
    _formValidation('{{$form_id}}', true, 'workspace_modal');

    
    $('#members').tagsinput({
         addOnBlur:false,
         trimValue: true,
         triggerChange:true
    });

    $(document).on('keyup', '.bootstrap-tagsinput>input', function(){
        console.log('tariq');
    })



    $(document).on('keyup', '.bootstrap-tagsinput>input', function(){

        var val = $(this).val()


        console.log(val);

        var url = "{{ route('get-user-suggestion') }}";

        if(val.length > 1)
        {
            $.ajax({
                    type: 'GET',
                    url: url,
                    data : {value : val},
                    success : function(data)
                    {
                        
                        if(data)
                        {
                            var res = ''
                            res += `<ul class="asign_dropdown_list" >`

                        for(let i = 0; i < data.length; i++){

                            res += `<li>
                                <div class="single_asign_member d-flex" data-value="${data[i].email}">
                                    <div class="asign_avater">AS</div>
                                    <div class="asign_title"><span>${data[i].name}</span></div>
                                    <div class="asign_subtitle"><span>${data[i].email}</span></div>
                                </div>
                                </li>`

                            }

                            res +=`</ul>`;
                            $('#user-suggestion-list').html(res)
                        }

                    },
                    error : function(error)
                    {
                        ajax_error(error)
                    }
                })
        }
    })


    $(document).on('click', '.single_asign_member', function(e){
        e.preventDefault();

           let email = $(this).data('value');

        $('#members').tagsinput('add', email);
        $(".bootstrap-tagsinput>input").val("").focus();
        $('#user-suggestion-list').html("");

                
    })


    function validateEmail(email) {
        const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }





</script>

