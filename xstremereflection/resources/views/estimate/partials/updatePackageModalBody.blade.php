<form action="/updatePackage/{{$package->id }}" method="post">
    @csrf
    <div class="form-group">
        <label>Price</label>
        <input type="number" step="0.01" class="form-control" name="chargedPrice" />
    </div>

    <button type="submit" class="btn btn-primary btn-block">Submit Changes</button>
</form>
