<div>
    @section('title', 'Message Me')

   <x-layout.pageheader />

    <div class="container mx-auto">
        <h1 class="text-2xl font-normal mb-4 text-center">
            New Message
        </h1>

        <div class="w-1/2 mx-auto">

            <form wire:submit.prevent="save">

                <div class="field mb-6">
                    <label class="block">
                        <span class="text-gray-700">Name in Full</span>
                        <input wire:model='name' type="text" class="form-input mt-1 block w-full" name='name' placeholder="Please your name.">
                        @error('name') <span class="mt-1 text-red-700 font-bold text-sm"> {{ $message }}</span> @enderror
                    </label>
                </div>

                <div class="field mb-6">
                    <label class="block">
                        <span class="text-gray-700">Email</span>
                        <input wire:model='email' type="Email" class="form-input mt-1 block w-full" name='email' placeholder="Please enter your email address.">
                        @error('email') <span class="mt-1 text-red-700 font-bold text-sm"> {{ $message }}</span> @enderror
                    </label>
                </div>

                <div class="field mb-6">
                    <label class="block">
                        <span class="text-gray-700">Subject</span>
                        <input wire:model='subject' type="text" class="form-input mt-1 block w-full" name='subject' placeholder="Please enter a subject.">
                        @error('subject') <span class="mt-1 text-red-700 font-bold text-sm"> {{ $message }}</span> @enderror
                    </label>
                </div>

                <div class="field mb-6">
                    <label class="block">
                        <span class="text-gray-700">Query</span>
                        <textarea wire:model='content' class="form-textarea mt-1 block w-full" name='content' rows="3" placeholder="Please enter your comment or question."></textarea>
                        @error('content') <span class="mt-1 text-red-700 font-bold text-sm"> {{ $message }}</span> @enderror
                    </label>
                </div>

                <div class="field mb-6">
                    <label class="block">
                        <span class="text-gray-700">Question for Humans</span>
                        <input wire:model='my_question' type="text" class="form-input mt-1 block w-full" name='my_question' placeholder="Please enter the nationality of the artist stated in the title.">
                        @error('my_question') <span class="mt-1 text-red-700 font-bold text-sm"> {{ $message }}</span> @enderror
                    </label>
                </div>

                <div class="field">
                    <div class="control">
                        <button class="btn btn-blue is-link mr-2">Save</button>
                        <a href="{{ '/' }}" class="text-default">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>