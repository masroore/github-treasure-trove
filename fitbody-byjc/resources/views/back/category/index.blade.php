@extends('back.layouts.backend')

@section('content')

    <div class="content">
        <h2 class="content-heading">Kategorije
            <small>
                <span class="float-right">
                    <div class="dropdown float-right ml-5">
                        <button type="button" class="btn btn-secondary dropdown-toggle" id="products-status" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Grupe
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="products-status" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(48px, 31px, 0px);">
                            @foreach($groups as $group)
                                <button class="dropdown-item" onclick="SelectGroup('{{ $group }}')">
                                    <i class="fa fa-fw fa-star text-success mr-5"></i>{{ \Illuminate\Support\Str::upper($group) }}
                                </button>
                            @endforeach
                            <button class="dropdown-item active" onclick="SelectGroup('all')">
                                <i class="fa fa-fw fa-circle-o text-info mr-5"></i>Prikaži Sve
                            </button>
                        </div>
                    </div>
                    @if (Bouncer::is(auth()->user())->an('admin'))
                        <a href="{{ route('category.create') }}" class="btn btn-secondary ml-30" data-toggle="tooltip" title="Dodaj novu kategoriju">
                            <i class="si si-plus"></i> Dodaj Novu
                        </a>
                    @endif
                </span>
            </small>
        </h2>

        @include('back.layouts.partials.session')

        <div class="block black">
            <div class="block-content">
                <div class="table-responsive">
                <table class="js-table-sections table table-hover table-vcenter">
                    <thead>
                    <tr>
                        <th style="width: 30px;">#</th>
                        <th class="text-center" style="width: 81px;">Status</th>
                        <th>Ime</th>
                        <th class="text-center" style="width: 10%;">Podkategorije</th>
                        <th class="text-center" style="width: 25%;">Grupa</th>
                        <th class="text-center" style="width: 10%;">Redosljed</th>
                        @if (Bouncer::is(auth()->user())->an('admin'))
                            <th class="d-none d-sm-table-cell text-right" style="width: 80px;">Akcija</th>
                        @endif
                    </tr>
                    </thead>
                    @foreach($categories as $key => $category)
                        <tbody class="js-table-sections-header">
                        <tr>
                            <td class="text-center">{{ $key + 1 }}.</td>
                            <td class="text-center">
                                <i class="fa fa-fw fa-{{ $category->status ? 'star text-success' : 'warning text-danger' }}"></i>
                            </td>
                            <td class="font-w600">
                                <a href="{{ route('category.edit', ['id' => $category->id]) }}">{{ $category->name }}</a>
                            </td>
                            <td class="text-center pl-3">{{ $category->subcategory_count ? $category->subcategory_count : ($category->single_page ? '' : $category->subcategory_count) }}</td>
                            <td class="text-center text-uppercase font-size-xs">{{ strtoupper($category->group) }}</td>
                            <td class="text-center">{{ $category->sort_order }}</td>
                            <td class="d-none d-sm-table-cell text-right">
                                @if ( ! in_array($category->id, [1, 2, 3]))
                                    <button type="button" class="btn btn-sm btn-circle btn-alt-danger" data-toggle="tooltip" data-placement="left" title="Obriši {{ $category->name }}"
                                            onclick="event.preventDefault(); shouldDeleteCategory({{ json_encode($category) }});">
                                        <i class="fa fa-times"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                        </tbody>
                        @if ($category->subcategory_count > 0)
                            @foreach($category->subcategory as $subkey => $subcategory)
                                <tr>
                                    <td class="text-center"></td>
                                    <td class="text-center">
                                        <i class="fa fa-fw fa-{{ $subcategory->status ? 'star text-success' : 'warning text-danger' }}"></i>
                                    </td>
                                    <td class="font-w600 text-gray-dark">
                                        <a href="{{ route('category.edit', ['id' => $subcategory->id]) }}" class="text-gray-dark">{{ $subkey + 1 }}. <span class="pl-3">{{ $subcategory->name }}</span></a>
                                    </td>
                                    <td></td>
                                    <td class="text-center text-uppercase font-size-xs">{{ $category->name . ' - ' . $subcategory->name }}</td>
                                    <td class="text-center">{{ $subcategory->sort_order }}</td>
                                    <td class="text-right font-size-sm">
                                        <button type="button" class="btn btn-sm btn-circle btn-alt-danger" data-toggle="tooltip" data-placement="left" title="Obriši {{ $subcategory->name }}"
                                                onclick="event.preventDefault(); shouldDeleteCategory({{ json_encode($subcategory) }});">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="font-w600 text-gray-dark"><span class="text-gray-dark pl-3">{{ $category->single_page ? 'Ovo je samostalna stranica!' : 'Nemate podkategorija!' }}</span></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endif
                    @endforeach
                </table>
                </div>
            </div>
        </div>

    </div>

@endsection

@push('js_after')
    <!-- Page JS Helpers (Table Tools helper) -->
    <script>
      jQuery(function () {
        Codebase.helpers('table-tools');
      });

      function shouldDeleteCategory(category) {
        console.log(category)

        confirmPopUp.fire({
          title: 'Jeste li sigurni?',
          text: 'Potvrdite brisanje kategorije: ' + category.name,
          type: 'warning',
          confirmButtonText: 'Da, Obriši!',
        }).then((result) => {
          if (result.value) {
            deleteCategory(category)
          }
        })
      }

      function deleteCategory(category) {
        axios.post("{{ route('category.destroy') }}", {data: category})
          .then(r => {
            if (r.data) {
              successToast.fire({
                text: '',
              })

              location.reload()
            }
          })
          .catch(e => {
            errorToast.fire({
              text: e,
            })
          })
      }

      function SelectGroup(group) {
          let url = new URL(location.href)
          let params = new URLSearchParams(url.search)
          let keys = []

          for(var key of params.keys()) {
              if (key === 'group') {
                  keys.push(key)
              }
          }

          keys.forEach((value) => {
              if (params.has(value)) {
                  params.delete(value)
              }
          })

          if (group && group !== 'all') {
              params.append('group', group)
          }

          url.search = params
          location.href = url
      }
    </script>
@endpush
