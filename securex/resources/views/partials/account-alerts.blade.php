@if (session('banned'))
<div class="alert alert-danger" role="alert">
    <strong>!! Account Banned !!</strong>
    <br />Reason: {{ session('banned') }}
    <br />Contact Support for more info.
</div>
@endif