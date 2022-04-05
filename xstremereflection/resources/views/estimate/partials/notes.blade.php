<div class="card">
    <div class="card-body py-0 px-0 px-sm-3">
        <h2>Notes or Actions</h2>

        <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#noteModal"> Add New Note</button>
            <ul class="list-group">
                @foreach($estimate->tracking as $note)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{$note->note}}
                    <small><span> {{\Carbon\Carbon::parse($note->created_at)->diffForHumans()}} </span></small>
                </li>
                @endforeach
            </ul>




    </div>
</div>
