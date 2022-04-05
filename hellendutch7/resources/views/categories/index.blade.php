<x-layout.app>

  @section('title', 'Categories')


  <x-layout.pageheader />

  <div class="container mx-auto pb-4">

    <div class="flex flex-col md:flex-row justify-between">

      <x-layout.dash_left />
      <div class="container mx-auto pb-4">
        <div class="text-center">
          <h1 class="font-bold text-3xl m-2 ">Categories</h1>
        </div>
        <div class="flex flex-col ">
          <div class="w-3/5 mx-auto">
            <div class="bg-white shadow-md rounded my-6">
              <table class="text-left w-full border-collapse">
                <!--Border collapse doesn't work on this site yet but it's available in newer tailwind versions -->
                <thead>
                  <tr>
                    <th class="py-2 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-t border-b border-r  border-grey-light">Category</th>
                    {{-- <th class="text-center py-2 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-t  border-b border-r  border-grey-light">Type</th>  --}}
                    <th class="text-center py-2 px-6 font-bold uppercase text-sm text-grey-dark border-t  border-b border-r  border-grey-light">Active</th>
                    <th class="py-2  bg-grey-lightest font-bold uppercase text-sm text-center text-grey-dark border-t  border-b border-grey-light">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($categories as $category)
                  <tr class="hover:bg-grey-lighter">
                    <td class="py-2 px-6 border-b border-r border-grey-light">{{ $category->category }}</td>
                    {{-- <td class="text-center py-2 px-6 border-b border-r  border-grey-light">{{ $category->type }}</td> --}}
                    @if( $category->active ===1)
                    <td class="text-center border-b border-r  border-grey-light"><i class="far fa-check-circle"></i></td>
                    @else
                    <td class="text-center border-b border-r  border-grey-light"></td>
                    @endif
                    <td class="flex justify-center py-3 border-b border-r  border-grey-light">
                      <div class="text-grey-lighter text-sm mr-2 hover:font-semibold"><a href="\category\create"><i class="fas fa-plus"></i></a></div>
                      <div class="text-grey-lighter text-sm mr-2 hover:font-semibold"><a href="{{ $category->path() }}/edit"><i class="far fa-edit"></i></a></div>
                      <div class="text-grey-lighter text-sm mr-2 ">
                        <form method="POST" action="{{ $category->path() }}">
                          @method('DELETE')
                          @csrf
                          <button class="hover:font-semibold" type="submit"><i class="far fa-trash-alt"></i></button>
                        </form>
                      </div>
                    </td>
                  </tr>
                  @endforeach

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

</x-layout.app>