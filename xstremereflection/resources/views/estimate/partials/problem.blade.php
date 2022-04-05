<div class="col-xl-12">
    <form action="/updateProblem/{{$estimate->id}}" method="post">
        <div class="col-xl-12 mb-2">
            @csrf
            <label>Reported Problem</label>
            <textarea  id="summernote" name="problem" style="width: 100%">
              {!! $estimate->problem ?? '' !!}
            </textarea>
        </div>
        <div class="col-xl-12">
            <button type="submit" class="btn btn-primary btn-sm btn-block">Update Reported Problem</button>
        </div>
    </form>
</div>

