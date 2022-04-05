<x-layout >
  <script src="https://hammerjs.github.io/dist/hammer.js"></script>

  <link rel="stylesheet" href="/vendor/glightbox/dist/css/glightbox.min.css">
  <style>
      .gslide-list{
          background-color:white;
          height:3rem;
          position: fixed;
          bottom:0 ;
          width:100%;    
      }
  </style>

  <div>
      <link rel="stylesheet" href="/css/upso.css?v=13">
          
      <x-common.top-title menu='매니저정보' mode='보기' />

      <div class="my-4 ">.</div>
      <x-common.top-title menu='매니저정보' mode='리스트' />

      @livewire('managers-list', [
        'upso_type_id' => $upso_type_id, 
        'main_region_id' => $main_region_id, 
        'region_id' => $region_id, 
      ])
  </div>
</x-layout>
