<div>
    {{-- Be like water. --}}

    mode :{{ $mode }} <br>
    ccat_id : {{  $ccat_id }} -- <p>

    </p>
    +++ {{  now() }}
    <div class="flex items-center justify-center">
        @if (session()->has('message'))
            <div class="text-red-500 mt-1">
                {{ session('message') }}
            </div>
        @endif
    </div>

    @php
        $q = request()->query();
    @endphp
    
    @json( $q)
    @if( $mode =='create')
        <x-customers.create />
    @elseif( $mode =='reply') 
    reply

    @elseif( $mode =='show')
    
    <div class="w-full ">
        show now : {{  now() }} - {{ $customer_id }}
        @livewire('customers.show-with-comments', ['customer_id' => $customer_id])
    </div>
    @endif
    <table class="table-auto w-full mt-2">
        <tr>
            <td colspan=5 class="text-right p-1 m-1 text-sm">
                <button 
                    wire:click="setMode('create')"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full my-2">
                    글쓰기
                </button>
            </td>
        </tr>

        <tr>
            <td class="border p-1 m-1 text-sm w-1/12 text-center">
                번호 
            </td>
            <td class="border p-1 m-1 text-sm w-6/12 text-center">제목 {{  now() }}</td>
            <td class="border p-1 m-1 text-sm w-2/12 text-center">이름</td>
            <td class="border p-1 m-1 text-sm w-2/12 text-center">날짜</td>
        </tr>
        @foreach( $customers as $item)
        {{-- {{ print_r($item)}} --}}
            <tr class="{{  $customer_id  == $item->id ? 'bg-gray-300': '' }}">
                <td class="border p-1 m-1 text-sm text-center">
                {{ $item->id  }}
                </td>
                <td class="border p-1 m-1 text-sm ">
                <div 
                    wire:click="showMe({{  $item->id }})"
                
                    class="flex px-2">
                    <svg class="w-4 h-4 fill-current text-yellow-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M4 8V6a6 6 0 1 1 12 0v2h1a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-8c0-1.1.9-2 2-2h1zm5 6.73V17h2v-2.27a2 2 0 1 0-2 0zM7 6v2h6V6a3 3 0 0 0-6 0z"/>
                    </svg>
                    {{-- <a href="/customers/{{ $item->id}}?page={{ $customers->currentPage() }}" class="px-2" > --}}
                    <div class="px-2">{{ $item->title  }}</div>
                    {{-- </a> --}}
                </div>
                </td>
                <td class="border p-1 m-1 text-sm text-center">
                    {{ $item->title  }}
                </td>
                <td class="border p-1 m-1 text-sm text-center">{{ \Carbon\Carbon::parse($item->created_at)->format('m:d h:i')  }}</td>
            </tr>
        @endforeach 
    
        <tr>
            <td colspan=5 class="text-right p-1 m-1 text-sm">
                {{ $customers->appends(request()->query())->links('vendor.pagination.tailwindcss') }}
            </td>
        </tr>
        <tr>
            <td colspan=5 class="text-right p-1 m-1 text-sm">
                <button 
                    wire:click="setMode('create')"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full my-2">
                    글쓰기
                </button>
            </td>
        </tr>
    </table>


    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
            window.livewire.on('urlChange', (url) => {
                history.pushState(null, null, url);
            });
        });
    </script>

</div>
