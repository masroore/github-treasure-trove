<x-layout >

    @include('flash-message')
    <x-jet.form-section action="/profile" method="POST" class="mt-6"
        {{-- submit="updatePassword" --}}
    >
        
        <x-slot name="title">
            {{  Auth::user()->nick }} 님 정보 
        </x-slot>

        <x-slot name="description">
            정보 수정
        </x-slot>

        <x-slot name="form">
            <div class="col-span-6 sm:col-span-4">
                <x-jet.label for="current_password" value="현재 비밀번호" />
                <x-jet.input id="current_password" type="password" 
                    name="current_password"
                    class="mt-1 block w-full border border-gray-600 p-2 " 
                    autocomplete="current-password" />
                <x-jet.input-error for="current_password" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-jet.label for="password" value="신규 비밀번호" />
                <x-jet.input id="password" type="password" 
                    name="password" 
                    class="mt-1 block w-full border border-gray-600 p-2" 
                    autocomplete="new-password" />
                <x-jet.input-error for="password" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-jet.label for="password_confirmation" value="{{ __('신규 비밀번호 확인') }}" />
                <x-jet.input id="password_confirmation" type="password" 
                name="password_confirmation" 
                    class="mt-1 block w-full border border-gray-600 p-2" 
                    autocomplete="new-password" />
                <x-jet.input-error for="password_confirmation" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="actions">
            
            {{-- <x-jet.action-message class="mr-3" on="saved">
                {{ __('Saved.') }}
            </x-jet.action-message> --}}

 

            
            <button button type="submit"
                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150"
            
            >
                {{ __('확인') }}
            </button>
        </x-slot>
    </x-jet.form-section>


</x-layout>