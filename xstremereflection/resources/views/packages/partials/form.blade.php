<form action="/package/store" id="addPackageForm" method="post">
    @csrf

        <div class="form-group">
            <label for="description">Package Name (required, at least 2 characters) <span class="text-danger">*</span> </label>
            <input id="description" class="form-control" name="description" minlength="2" type="text" required>
        </div>
        <div class="form-group">
            <label for="cost">Package Cost <span class="text-danger">*</span> </label>
            <input id="cost" class="form-control" type="decimal" step="0.00" name="cost" placeholder="199.99" required>
        </div>
        <div class="form-group">
            <label for="most_purchased"><input id="most_purchased" class="form-check-input" type="checkbox" value="1" name="most_purchased"> Mark item as most purchased (optional)</label>
        </div>
        <div class="form-group">
            <label>Select the package type <span class="text-danger">*</span> </label>
            <select class="form-control" name="packageType" >
                @foreach($packageTypes as $row)
                <option value="{{$row->id}}">{{$row->description}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Package Description</label>
            <textarea  id="summernote" name="description" style="width: 100%">

            </textarea>
        </div>

        <div class="form-group">
            <label for="productCost">Total Cost of products used. <span class="text-danger">*</span> </label>
            <input id="cost" class="form-control" type="decimal" step="0.01" name="productCost" value="0.00" required>
        </div>

        <div class="form-group">
            <label for="laborCost">Total Cost of labor. <span class="text-danger">*</span> </label>
            <input id="laborCost" class="form-control" type="decimal" step="0.01" name="laborCost" value="0.00" required>
        </div>
        <div class="form-group">
            <label for="acquisitionCost">Total Cost of acquisition. ex.insurance/advertisement <span class="text-danger">*</span> </label>
            <input id="acquisitionCost" class="form-control" type="decimal" step="0.01" name="acquisitionCost" value="0.00" required>
        </div>
        <input class="btn btn-primary" type="submit" value="Submit">

</form>
