@section('page_title')
    CHAT
@endsection

<div wire:poll.5000ms x-data="{show_chatrooms : false}" class="relative flex h-full">

    <div x-data="{show_details : false}" class="relative flex flex-col flex-1 h-full space-y-2 bg-white md:p-4">
        <div x-cloak @click.away="show_details = false" x-show="show_details" x-transition.opacity
            class="absolute inset-y-0 right-0 z-20 px-4 py-8 bg-gray-200 shadow-lg w-96">
            @if ($active_chatroom?->course_id)
                <div>
                    <div class="flex space-x-2">
                        <input class="flex-1 w-full" wire:model.lazy="new_member" placeholder="User email..."
                            type="text">
                        <button wire:click="add_member" class="px-4 button-primary">Add</button>
                    </div>
                    <div class="mt-4">
                        <h3 class="title">Members</h3>
                        <ul class>
                            @foreach ($active_chatroom->users as $user)
                                <li class="text-sm italic">{{ $user->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </div>
        <h3 class="bg-primary-500 !mt-0 text-white p-4 flex items-center justify-between">
            <div class="flex space-x-2">
                @if ($active_chatroom ? ($active_chatroom->course_id ? $active_chatroom->course->image_url : $active_chatroom?->profile_photo) : $recipient?->profile_photo)
                    <div class="relative flex-shrink-0 w-8 h-8">
                        <img class="h-full bg-cover rounded-full"
                            src="{{ $active_chatroom ? ($active_chatroom->course_id ? $active_chatroom->course->image_url : $active_chatroom?->profile_photo) : $recipient?->profile_photo }}"
                            alt="profile photo">
                    </div>
                @endif
                <div class="flex items-center">
                    <span>{{ $active_chatroom?->name ?? $recipient?->name }}</span>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <button class="focus:outline-none md:hidden hover:text-primary-600" @click="show_chatrooms = true">
                    <x-gmdi-search-r />
                </button>
                <button class="focus:outline-none hover:text-primary-600" @click="show_details = true">
                    <x-gmdi-menu-r />
                </button>
            </div>
        </h3>
        <div x-data @scroll="
            if ($refs.message_box.scrollTop + $refs.message_box.scrollHeight - 2 <= $refs.message_box.offsetHeight){
                @this.message_per_page += 5;
            }
        " x-ref="message_box"
            class="relative flex flex-col flex-col-reverse flex-1 px-4 space-y-2 space-y-reverse overflow-y-auto">
            @if ($active_chatroom)
                @forelse ($messages as $message)
                    @if ($message->user_id)
                        @if ($message->user_id == auth()->id())
                            <div wire:key="message.{{ $message->id }}" x-data="{show_seen:false}"
                                title="{{ $message->readable_date_sent }}"
                                class="flex items-start justify-end space-x-2">
                                <div class="relative flex items-center h-full">
                                    <button @click="show_seen = !show_seen" class="focus:outline-none">
                                        <x-gmdi-menu class="text-gray-300 group-hover:text-gray-500" />
                                    </button>
                                </div>
                                <span class="text-sm text-white md:max-w-[50%] inline-block">
                                    <h6 class="text-xs tracking-tighter text-right title-sm">
                                        {{ $message->readable_date_sent }}</h6>
                                    <p class="p-2 text-justify bg-blue-600 rounded">{{ $message->body }}</p>
                                    <div @click.away="show_seen = false" x-cloak x-show="show_seen"
                                        x-transition.opacity.duration.300ms class="text-xs text-gray-600">
                                        <h5 class="text-right">Seen by
                                            {{ $active_chatroom->users()->wherePivot('message_id', '>=', $message->id)->count() }}
                                        </h5>
                                    </div>
                                </span>
                                <img title="{{ $message->sender->name }}" class="w-8 rounded-full"
                                    src="{{ auth()->user()->profile_photo }}" alt="profile photo">
                            </div>
                        @else
                            <div wire:key="message.{{ $message->id }}" x-data="{show_seen:false}"
                                title="{{ $message->readable_date_sent }}" class="flex items-start space-x-2 group">
                                <img title="{{ $message->sender->name }}" class="w-8 rounded-full"
                                    src="{{ $message->sender->profile_photo }}" alt="profile photo">
                                <span class="text-sm text-white md:max-w-[50%] inline-block">
                                    <h6 class="text-xs tracking-tighter title-sm">{{ $message->readable_date_sent }}
                                    </h6>
                                    <p class="p-2 text-justify rounded bg-primary-500">{{ $message->body }}</p>
                                    <div @click.away="show_seen = false" x-cloak x-show="show_seen"
                                        x-transition.opacity.duration.300ms class="text-xs text-gray-600">
                                        <h5>Seen by
                                            {{ $active_chatroom->users()->wherePivot('message_id', '>=', $message->id)->count() }}
                                        </h5>
                                    </div>
                                </span>
                                <div class="relative flex items-center h-full">
                                    <button @click="show_seen = !show_seen" class="focus:outline-none">
                                        <x-gmdi-menu class="text-gray-300 group-hover:text-gray-500" />
                                    </button>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="flex items-start self-center space-x-2">
                            <span
                                class="inline-block p-2 text-xs text-center text-white rounded bg-primary-600">{{ $message->body }}</span>
                        </div>
                    @endif
                @empty
                    <div class="flex items-start self-center space-x-2">
                        <span class="inline-block p-2 text-xs text-center text-white rounded bg-primary-600">This is the
                            start of the conversation</span>
                    </div>
                @endforelse
                <h1 class="text-center title-sm animate-pulse">Loading messages...</h1>
            @else
                <div class="grid flex-1 place-items-center">
                    <h4>Start a conversation...</h4>
                </div>
            @endif
        </div>
        <form wire:submit.prevent="send_message" class="flex space-x-1">
            <div class="relative flex-1">
                <input autofocus wire:model.defer="message" placeholder="Your message..." type="text"
                    class="w-full text-xs rounded">
                <x-gmdi-refresh-r wire:loading wire:target="send_message" class="absolute animate-spin right-1 top-1" />
            </div>
            <button type="submit" class="px-6 rounded button-primary">SEND</button>
        </form>
    </div>
    <div x-cloak :class="show_chatrooms ? 'absolute' : 'hidden'"
        class="inset-0 flex-col h-full p-4 space-y-2 bg-gray-100 md:flex md:w-1/4 md:inset-auto md:border-l border-primary-500">
        <div class="flex items-center">
            <div class="relative flex-1">
                <x-gmdi-refresh-r wire:loading.delay class="absolute animate-spin right-1 top-1" />
                <input wire:model="search" type="text" placeholder="Search conversations..."
                    class="w-full text-xs rounded-full">
            </div>
            <button class="md:hidden" @click="show_chatrooms = false">
                <x-gmdi-close-r class="text-red-600" />
            </button>
        </div>
        <ul x-data x-ref="contacts_box" @scroll="
            if ($refs.contacts_box.scrollHeight - $refs.contacts_box.scrollTop - 2 <= $refs.contacts_box.offsetHeight){
                @this.chatrooms_per_page += 5;
            }
        " class="flex flex-col flex-1 space-y-1 overflow-y-auto">
            @if ($search)
                <h5 class="title-sm">Conversations</h5>
                @forelse ($chatrooms as $chatroom)
                    <button @click="show_chatrooms = false" wire:click="change_active_chatroom({{ $chatroom->id }})"
                        class="text-left focus:outline-none">
                        <li title="{{ $chatroom->name }}"
                            class="@if ($chatroom->latest_message?->unread($chatroom->pivot->message_id)){{ 'bg-blue-200' }} @else {{ 'bg-gray-100' }} @endif flex items-center space-x-2 hover:bg-gray-200 p-2">
                            <div class="relative flex-shrink-0 w-12 h-12">
                                @if ($chatroom->latest_message?->unread($chatroom->pivot->message_id))
                                    <div
                                        class="absolute top-0 right-0 w-4 h-4 bg-blue-600 border-2 border-white rounded-full">
                                    </div>
                                @endif
                                <img class="h-full bg-cover rounded-full"
                                    src="{{ $chatroom->course_id ? $chatroom->course->image_url : $chatroom?->profile_photo }}"
                                    alt="profile photo">
                            </div>
                            <div class="overflow-hidden w-96">
                                <h4 class="truncate">{{ $chatroom->name }}</h4>
                                <h5 class="text-xs @if ($chatroom->latest_message?->unread($chatroom->pivot->message_id)){{ 'font-bold' }}@endif truncate text-gray-600"><strong
                                        class="font-semibold">{{ $chatroom->latest_message?->sender?->name ?? 'System' }}:</strong>
                                    {{ $chatroom->latest_message?->body }}</h5>
                            </div>
                        </li>
                    </button>
                @empty
                    <li title="{{ auth()->user()->name }}"
                        class="flex items-center p-2 space-x-2 bg-gray-100 hover:bg-gray-200">
                        <div>
                            <h4 class="text-center title-sm">No matching conversations found.</h4>
                        </div>
                    </li>
                @endforelse
                <h5 class="title-sm">Users</h5>
                @forelse ($users as $user)
                    <button @click="show_chatrooms = false" wire:click="change_recipient({{ $user->id }})"
                        class="text-left focus:outline-none">
                        <li title="{{ $user->name }}" class="flex items-center p-2 space-x-2 hover:bg-gray-200">
                            <div class="relative flex-shrink-0 w-12 h-12">
                                <img class="h-full bg-cover rounded-full" src="{{ $user->profile_photo }}"
                                    alt="profile photo">
                            </div>
                            <div class="overflow-hidden w-96">
                                <h4 class="truncate">{{ $user->name }}</h4>
                            </div>
                        </li>
                    </button>
                @empty
                    <li title="{{ auth()->user()->name }}"
                        class="flex items-center p-2 space-x-2 bg-gray-100 hover:bg-gray-200">
                        <div>
                            <h4 class="text-center title-sm">No matching users found.</h4>
                        </div>
                    </li>
                @endforelse
            @else
                @forelse ($chatrooms as $chatroom)
                    <button @click="show_chatrooms = false" wire:click="change_active_chatroom({{ $chatroom->id }})"
                        class="text-left focus:outline-none">
                        <li title="{{ $chatroom->name }}"
                            class="@if ($chatroom->latest_message?->unread($chatroom->pivot->message_id)){{ 'bg-blue-200' }} @else {{ 'bg-gray-100' }} @endif flex items-center space-x-2 hover:bg-gray-200 p-2">
                            <div class="relative flex-shrink-0 w-12 h-12">
                                @if ($chatroom->latest_message?->unread($chatroom->pivot->message_id))
                                    <div
                                        class="absolute top-0 right-0 w-4 h-4 bg-blue-600 border-2 border-white rounded-full">
                                    </div>
                                @endif
                                <img class="h-full bg-cover rounded-full"
                                    src="{{ $chatroom->course_id ? $chatroom->course->image_url : $chatroom?->profile_photo }}"
                                    alt="profile photo">
                            </div>
                            <div class="overflow-hidden w-96">
                                <h4 class="truncate">{{ $chatroom->name }}</h4>
                                <h5 class="text-xs @if ($chatroom->latest_message?->unread($chatroom->pivot->message_id)){{ 'font-bold' }}@endif truncate text-gray-600"><strong
                                        class="font-semibold">{{ $chatroom->latest_message?->sender?->name ?? 'System' }}:</strong>
                                    {{ $chatroom->latest_message?->body }}</h5>
                                <h4 class="text-xs font-semibold text-right text-gray-500">
                                    {{ $chatroom->latest_message?->readable_date_sent }}</h4>
                            </div>
                        </li>
                    </button>
                @empty
                    <li title="{{ auth()->user()->name }}"
                        class="flex items-center p-2 space-x-2 bg-gray-100 hover:bg-gray-200">
                        <div>
                            <h4 class="text-center title">No chatrooms yet. Start a conversation.</h4>
                        </div>
                    </li>
                @endforelse
            @endif
        </ul>
    </div>
</div>
