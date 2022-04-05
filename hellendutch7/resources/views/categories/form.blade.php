@csrf

@include ('errors')
<div class="field mb-6">
    <label class="block">
      <span class="text-gray-700">Category</span>
        <input  type="text" class="form-input mt-1 block w-full" 
                name='category'
                placeholder="Enter the name of the category."
                value="{{old('category', $category->category)}}">
    </label>
</div>

<input type="hidden" name="active" value="0">
<div class="block mb-4">
  <span class="text-gray-700">Active</span>
  <div class="mt-2">
    <div class="flex flex-wrap ">
        <label class="mx-2 inline-flex items-center">
          <input class="form-checkbox text-indigo-600"
                  type="checkbox" 
                  name='active' @if(old('active',$category->active)=="1") checked @endif
                  value='1' />
          <span class="ml-2"></span>
        </label>
    </div>
  </div>
</div>

<div class="field">
    <div class="control">
        <button type="submit" class="btn btn-blue is-link mr-2">{{ $buttonText }}</button>

        <a href="/category" class="text-default">Cancel</a>
    </div>
</div>



