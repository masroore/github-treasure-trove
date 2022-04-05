<div>
    @section('title', 'My Messages')

<x-layout.pageheader />

    <div class="container mx-auto pb-4">

        <div class="flex flex-col md:flex-row justify-between">
            <x-layout.dash_left/>
            <div class="container mx-auto pb-4">
                <div class="text-center">
                    <h1 class="font-bold text-3xl m-2 ">Messages</h1>
                </div>
                <div class="flex flex-col ">
                    <div class="w-4/5 mx-auto">
                        @if(!$readMode)
                        <div class="bg-white shadow-md rounded my-6">
                            <table class="text-left w-full border-collapse">
                                <!--Border collapse doesn't work on this site yet but it's available in newer tailwind versions -->
                                <thead>
                                    <tr>
                                        <th class="py-2 px-4 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-t border-b border-r  border-grey-light">Date</th>
                                        <th class="py-2 px-4 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-t  border-b border-r  border-grey-light">From</th>
                                        <th class="py-2 px-4 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-t  border-b border-r  border-grey-light">Email</th>
                                        <th class="py-2  bg-grey-lightest font-bold uppercase text-sm text-center text-grey-dark border-t  border-b border-grey-light">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($messages as $message)
                                    <tr class="hover:bg-grey-lighter">
                                        <td class="py-2 px-4 border-b border-r border-grey-light">{{ $message->created_date }}</td>
                                        <td class="py-2 px-4 border-b border-r  border-grey-light">{{ $message->name }}</td>
                                        <td class="py-2 px-4 border-b border-r  border-grey-light">{{ $message->email }}</td>
                                        <td class="flex items-center justify-center py-3 border-b border-r  border-grey-light">
                                            <div class="text-grey-lighter text-sm mr-2 hover:font-semibold">
                                                <button wire:click="read({{ $message->id }})" class="mr-4 text-indigo-600 hover:text-indigo-900">Read</button>
                                                <button wire:click="destroy({{ $message->id }})" class="text-red-600 hover:text-red-900">Delete</button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        @endif
                        @if($readMode)
                        <div>
                            <div>
                                <div class="text-xl border rounded py-2 mb-4  ">
                                    <div class="flex mb-2 ">
                                        <div class="w-1/5  text-right font-semibold ">From:-</div>
                                        <div class="flex-1 pl-4 ">{{ $name }}</div>
                                    </div>
                                    <div class="flex mb-2">
                                        <div class="w-1/5  text-right font-semibold ">Email:-</div>
                                        <div class="flex-1 ml-4">{{ $email }}</div>
                                    </div>
                                    <div class="flex mb-2">
                                        <div class="w-1/5  text-right font-semibold ">Subject:-</div>
                                        <div class="flex-1 ml-4">{{ $subject }}</div>
                                    </div>
                                    <div class="flex mb-2">
                                        <div class="border-t-2 w-1/5  text-right font-semibold ">Message:-</div>
                                        <div class="border-t-2 flex-1 ml-4">{!! nl2br($content) !!}</div>
                                    </div>

                                </div>
                                <div class="field">
                                    <div class="control text-right">
                                        <button wire:click="back({{ $messageId }})" class="mr-4 text-blue-700 hover:text-blue-900">Done</button>
                                        <button wire:click="destroy({{ $messageId }})" class="mr-4 text-red-600 hover:text-red-900">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif


                </div>
            </div>

        </div>
    </div>
</div>
</div>
