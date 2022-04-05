<div class="">
    <form wire:submit.prevent='save'>
        <h1 class="text-2xl font-semibold text-gray-900">Profile</h1>
        <div class="w-1/2 mx-auto">
            <div>
                <div class="space-y-10 sm:mt-5">
                    <div class="mb-4">
                        <label class=" block mx-4 pt-2 ">
                            <span class="text-gray-700">User Name</span>
                            <input wire:model='name' id='name' type="text" class="form-input mt-1 block w-full" placeholder="Enter the Page name">
                            @error('name') <span class="mt-1 text-red-500 text-sm"> {{ $message }}</span> @enderror
                        </label>
                    </div>
                    <div class="mb-4">
                        <label class=" block mx-4 pt-2 ">
                            <span class=" text-gray-700">About Me</span>
                        <textarea wire:model='about' id="about" rows="5" class="form-input mt-1 block w-full" placeholder="Enter your content here"></textarea>
                        @error('content') <span class="mt-1 text-red-500 text-sm"> {{ $message }}</span> @enderror
                        <p class="mt-2 text-sm text-gray-500">Write a few sentences about yourself.</p>
                        </label>
                    </div>
                    <div class="mb-4">
                        <label class=" block mx-4 pt-2 ">
                            <span class=" text-gray-700 mb-4">Photo</span>
                        <div class="flex items-center">
                            <span class="h-12 w-12 rounded-full overflow-hidden bg-gray-100">
                                <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </span>
                            <span class="ml-5 rounded-md shadow-sm">
                                <button type="button" class="py-2 px-3 border border-gray-300 rounded-md text-sm leading-4 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out">
                                    Change
                                </button>
                            </span>
                        </div>
                        </label>
                    </div>
                </div>
                <div class="mt-8 border-t border-gray-200 pt-5">
                    <div class=" flex justify-start items-center">

                        <span class="ml-3 inline-flex rounded-md shadow-sm">
                            <button type="button" class="py-2 px-4 border border-gray-300 rounded-md text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out">
                                Cancel
                            </button>
                        </span>
                        <span class="ml-3 inline-flex rounded-md shadow-sm">
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                                Save
                            </button>
                        </span>
                        <span x-data="{ open: false }" x-init="
                        @this.on('notify-saved', () => {
                            if (open === false) setTimeout(() => { open = false }, 2500);
                            open = true;
                        })
                    " x-show.transition.out.duration.1000ms="open" style="display: none;" class="ml-4 text-green-500">Saved!</span>
                    </div>
                </div>
            </div>
        </div>

    </form>
</div>
