<x-layout.app>

    @section('title', 'Why Borneo')

        <x-layout.pageheader />

        <div class="container pb-4 mx-auto">

            <div class="flex flex-col justify-between md:flex-row">

                @include('dashboard.components.dash_left')

                <div class="container flex flex-col pb-4 mx-auto">
                    <div class="text-center">
                        <h1 class="m-2 text-3xl font-bold ">New Feature Coming Soon</h1>
                    </div>
                    <div class="mx-auto mb-4 ">
                        <img class="" src="{{ URL::asset('/images/smiley.jpg') }}">
                    </div>
                </div>

            </div>
        </div>
    </x-layout.app>
