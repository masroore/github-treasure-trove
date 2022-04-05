<div class="card profile-card">
    <div class="card-body">


        <div class="avatar-upload">
            <div class="avatar-edit">
                <input type='file' id="imageUpload" accept=".png, .jpg, .jpeg"/>
                <label for="imageUpload"></label>
            </div>
            <div class="avatar-preview">
                <div id="imagePreview"
                     style="background-image: url({{$user->photo == null ? asset('img/miscellaneous/woman-avatar.png'): asset('storage/moms/'.$user->id.'/'.$user->photo) }});">
                </div>
            </div>
        </div>

        <div class="profile-details">



            <ul class="list-group list-group-flush ">
                <li class="list-group-item bg-transparent border-top-0 border-ce-soir">
                    ID Usuario

                    <span class="float-right clearfix">
                   {{strtotime($user->created_at->format('Y-m-d h:i:s'))}}
                </span>

                <li class="list-group-item bg-transparent border-top-0 border-ce-soir">
                    Edad

                    <span class="float-right clearfix">
                    {{$user->momProfile ? $user->momProfile->birth_date->diffInYears('y').' años.':'Sin llenar'}}
                </span>
                </li>
                <li class="list-group-item bg-transparent border-ce-soir">
                    Ocupación
                    <span class="float-right clearfix">
                    {{$user->momProfile ?$user->momProfile->job :'Sin llenar'}}.
                </span>
                </li>
                <li class="list-group-item bg-transparent border-ce-soir">
                    Semana de embarazo
                    <span class="float-right clearfix">
                 {{$user->momProfile ? $user->momProfile->pregnancy_week:'Sin llenar'}}
                </span>
                </li>
                <li class="list-group-item bg-transparent border-bottom-0 border-ce-soir">
                    Teléfono
                    <span class="float-right clearfix">
                 {{$user->momProfile? $user->momProfile->phone: 'Sin llenar'}}
                </span>
                </li>


            </ul>


        </div>

    </div>
</div>
