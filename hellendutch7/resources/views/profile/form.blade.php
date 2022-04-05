@csrf

@include ('errors')

<div class=" field mb-6">
        <label class="block">
          <span class=" font-bold text-gray-800">Name</span>
            <input  type="text" class="form-input mt-1 block w-full"
                    name='name'
                    default=null
                    placeholder="Enter User name."
                    value="{{old('name',$user->name)}}">
        </label>
</div>

<div class=" field mb-6">
        <label class="block">
          <span class=" font-bold text-gray-800">Email</span>
            <input  type="text" class="form-input mt-1 block w-full"
                    name='email'
                    placeholder="Enter the Email."
                    value="{{old('email',$user->email)}}">
        </label>
</div>


    <div class=" field mb-6">
        <label class="block">
          <span class=" font-bold text-gray-800">Password</span>
            <input  type="password" class="form-input mt-1 block w-full"
                    name='password'
                    placeholder="Enter a Password."
                    value="{{old('name',$user->password)}}">
        </label>
</div>

    <div class=" field mb-6">
        <label class="block">
          <span class=" font-bold text-gray-800">Confirm Password</span>
            <input  type="password" class="form-input mt-1 block w-full"
                    name='password_confirmation'
                    value="{{old('name',$user->password)}}">
        </label>
</div>

<div class="field">
    <div class="control">
        <button type="submit" class="btn btn-blue is-link mr-2">{{ $buttonText }}</button>

        <a href="{{ url()->previous() }}" class="text-default">Cancel</a>
    </div>
</div>
