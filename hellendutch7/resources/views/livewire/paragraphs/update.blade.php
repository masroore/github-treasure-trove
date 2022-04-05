                       <div class="w-1/2 mx-auto mt-4">
                           <div class=" pt-2 mx-auto rounded-b-none text-center rounded text-bold bg-gray-200 text-xl">Update Paragraph</div>
                           <div class="w-full rounded  rounded-t-none shadow-lg border   pb-4">

                               <div class="">
                                   <label class=" block mx-4 pt-2 ">
                                       <span class="text-gray-700">Paragraph Content</span>
                                       <textarea wire:model='content' id='content' rows="5" class="form-input mt-1 block w-full" placeholder="Enter your content here"></textarea>
                                       @error('content') <span class="mt-1 text-red-500 text-sm"> {{ $message }}</span> @enderror
                                   </label>

                                   <div class="flex justify-around mx-4 block mt-4">
                                       <button wire:click="update()" class="button bg-green-500 ">Update Para</button>
                                   </div>

                               </div>
                           </div>
                       </div>