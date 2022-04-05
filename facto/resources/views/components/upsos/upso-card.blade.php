<div {{  $attributes->merge( ['class'=> '' ]) }} >
    <div class="bg-white shadow rounded hover:shadow-lg transition duration-200 transform hover:-translate-y-2 overflow-hidden my-5">
        <img src="{{  $image_server . $thumb_path }}" 
            class="h-48 w-full object-cover object-center">
        <div class="w-full flex flex-col">
            <h3 class="font-bold text-gray-700 w-full text-center mt-1 cursor-default text-lg">
                {{ $site_name }}
            </h3>
            <p class="p-3 pt-1 cursor-default">
                {{ $title }}
            </p>
            <button class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 m-2 focus:outline-none rounded">Look</button>
        </div>
    </div>
</div>