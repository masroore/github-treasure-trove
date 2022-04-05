                       <div class="pt-2 pb-2 mx-auto rounded rounded-b-none text-center rounded text-bold bg-gray-200 text-xl">Add Page</div>

                       <div class="rounded-md shadow-sm">
                           <div class="flex justify-between">
                               <label class="w-1/2 block mx-4 pt-2 ">
                                   <span class="text-gray-700">Page Name</span>
                                   <input wire:model='name' id='name' type="text" class="form-input mt-1 block w-full" placeholder="Enter the Page name">
                                   @error('name') <span class="mt-1 text-red-500 text-sm"> {{ $message }}</span> @enderror
                               </label>

                               <label class="w-1/2 block mx-4 pt-2 ">
                                   <span class="text-gray-700">Page Title</span>
                                   <input wire:model.lazy='title' id='title' type="text" class="form-input mt-1 block w-full" placeholder="Page Title goes here">
                                   @error('title') <span class="mt-1 text-red-500 text-sm"> {{ $message }}</span> @enderror
                               </label>
                           </div>
                           <label class="block mx-4 pt-2">
                               <span class="text-gray-700">Featured Image</span>
                               <input wire:model.lazy='featured_img' id='featured_img' type="text" class="form-input mt-1 block w-full" placeholder="Featured Image Url">

                               @error('featured_img') <span class="mt-1 text-red-500 text-sm"> {{ $message }}</span> @enderror
                           </label>
                           
                           <label class="block mx-4 pt-2">
                               <input wire:model='active' value='unchecked' class="mr-2 leading-tight" type="checkbox">
                               <span class="text-sm">
                                   Active
                               </span>
                               @error('active') <span class="mt-1 text-red-500 text-sm"> {{ $message }}</span> @enderror
                           </label>

                           <div class="flex justify-around mx-4 block mt-2">
                               <button wire:click="add()" class="button bg-green-500 ">Add New Page</button>
                           </div>

                       </div>