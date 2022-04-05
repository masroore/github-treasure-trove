@extends('dashboard.base')

@section('css')
    <link href="{{ asset('css/dataTables.bootstrap4.css') }}" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css" rel="stylesheet">
    <link href="{{ asset('css/daterangepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2-coreui.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dev/multiple-select.css') }}" rel="stylesheet">
@endsection

@section('content')
<!-- Icons-->
<link href="{{ asset('css/free.min.css') }}" rel="stylesheet"> <!-- icons -->
<link href="{{ asset('css/brand.min.css') }}" rel="stylesheet">
  {{ csrf_field() }}  
  <div class="container">
    <div class="row justify-content-around" style="background:#20202a;">
      <!--NUBE DE PALABRAS-->
      
      <div class="card col-md-6" style="background:transparent;border-color: transparent;">
        <div class="card-header text-center"><strong>Nube de Palabras</strong></div>
        <div class="card-body justify-content-center align-items-center" id="vis" style="background-color: #23242d;min-height: 310px !important;align-items:center;;align-content:center">
        
        </div>  
      </div>  



      <form id="form">

<p style="position: absolute; right: 0px; top: 0px;" id="status">202/202</p>

<div style="text-align: center">
  <div id="presets"></div>
  <div id="custom-area">
    <p><label for="text">Paste your text below!</label>
    </p><p><textarea id="text">How the Word Cloud Generator Works

The layout algorithm for positioning words without overlap is available on GitHub under an open source license as d3-cloud. Note that this is the only the layout algorithm and any code for converting text into words and rendering the final output requires additional development.

As word placement can be quite slow for more than a few hundred words, the layout algorithm can be run asynchronously, with a configurable time step size. This makes it possible to animate words as they are placed without stuttering. It is recommended to always use a time step even without animations as it prevents the browser’s event loop from blocking while placing the words.

The layout algorithm itself is incredibly simple. For each word, starting with the most “important”:

Attempt to place the word at some starting point: usually near the middle, or somewhere on a central horizontal line.
If the word intersects with any previously placed words, move it one step along an increasing spiral. Repeat until no intersections are found.
The hard part is making it perform efficiently! According to Jonathan Feinberg, Wordle uses a combination of hierarchical bounding boxes and quadtrees to achieve reasonable speeds.

Glyphs in JavaScript

There isn’t a way to retrieve precise glyph shapes via the DOM, except perhaps for SVG fonts. Instead, we draw each word to a hidden canvas element, and retrieve the pixel data.

Retrieving the pixel data separately for each word is expensive, so we draw as many words as possible and then retrieve their pixels in a batch operation.

Sprites and Masks

My initial implementation performed collision detection using sprite masks. Once a word is placed, it doesn't move, so we can copy it to the appropriate position in a larger sprite representing the whole placement area.

The advantage of this is that collision detection only involves comparing a candidate sprite with the relevant area of this larger sprite, rather than comparing with each previous word separately.

Somewhat surprisingly, a simple low-level hack made a tremendous difference: when constructing the sprite I compressed blocks of 32 1-bit pixels into 32-bit integers, thus reducing the number of checks (and memory) by 32 times.

In fact, this turned out to beat my hierarchical bounding box with quadtree implementation on everything I tried it on (even very large areas and font sizes). I think this is primarily because the sprite version only needs to perform a single collision test per candidate area, whereas the bounding box version has to compare with every other previously placed word that overlaps slightly with the candidate area.

Another possibility would be to merge a word’s tree with a single large tree once it is placed. I think this operation would be fairly expensive though compared with the analagous sprite mask operation, which is essentially ORing a whole block.

    </textarea>
    <button id="go" type="submit">Go!</button>
  </p></div>
</div>

<hr>

<div style="float: right; text-align: right">
  <p><label for="max">Number of words:</label> <input type="number" value="250" min="1" id="max">
  </p><p><label for="per-line"><input type="checkbox" id="per-line"> One word per line</label>
  <!--<p><label for="colours">Colours:</label> <a href="#" id="random-palette">get random palette</a>-->
  </p><p><label>Download:</label>
    <button id="download-svg">SVG</button><!-- |
    <a id="download-png" href="#">PNG</a>-->
</p></div>

<div style="float: left">
  <p><label>Spiral:</label>
    <label for="archimedean"><input type="radio" name="spiral" id="archimedean" value="archimedean" checked="checked"> Archimedean</label>
    <label for="rectangular"><input type="radio" name="spiral" id="rectangular" value="rectangular"> Rectangular</label>
  </p><p><label for="scale">Scale:</label>
    <label for="scale-log"><input type="radio" name="scale" id="scale-log" value="log" checked="checked"> log n</label>
    <label for="scale-sqrt"><input type="radio" name="scale" id="scale-sqrt" value="sqrt"> √n</label>
    <label for="scale-linear"><input type="radio" name="scale" id="scale-linear" value="linear"> n</label>
  </p><p><label for="font">Font:</label> <input type="text" id="font" value="Impact">
</p></div>

<div id="angles">
  <p><input type="number" id="angle-count" value="5" min="1"> <label for="angle-count">orientations</label>
    <label for="angle-from">from</label> <input type="number" id="angle-from" value="-60" min="-90" max="90"> °
    <label for="angle-to">to</label> <input type="number" id="angle-to" value="60" min="-90" max="90"> °
</p><svg width="151" height="70.5"><g transform="translate(75.5,60.5)"><path d="M -40.5 0 A 40.5 40.5 0 0 1 40.5 0" style="fill: none;"></path><line x1="-47.5" x2="47.5"></line><line y2="-47.5"></line><text dy=".3em" text-anchor="end" transform="rotate(0)translate(-50.5)rotate(0)translate(2)">-90°</text><text text-anchor="middle" transform="rotate(90)translate(-50.5)rotate(-90)translate(2)">0°</text><text dy=".3em" text-anchor="start" transform="rotate(180)translate(-50.5)rotate(-180)translate(2)">90°</text><path class="angle" d="M-35.07402885326976,-20.250000000000014A40.5,40.5 0 0,1 35.074028853269766,-20.25L0,0Z" style="fill: rgb(255, 204, 0);"></path><line class="angle" transform="rotate(30)" x2="-45.5"></line><line class="angle" transform="rotate(60)" x2="-40.5"></line><line class="angle" transform="rotate(90)" x2="-40.5"></line><line class="angle" transform="rotate(120)" x2="-40.5"></line><line class="angle" transform="rotate(150)" x2="-45.5"></line><path class="drag" d="M-9.5,0L-3,3.5L-3,-3.5Z" transform="rotate(30)translate(-40.5)"></path><path class="drag" d="M-9.5,0L-3,3.5L-3,-3.5Z" transform="rotate(150)translate(-40.5)"></path></g></svg></div>

<hr style="clear: both">

<p style="float: right"><a href="https://www.jasondavies.com/wordcloud/about/">How the Word Cloud Generator Works</a>.
</p><p style="float: left">Copyright © <a href="http://www.jasondavies.com/">Jason Davies</a> | <a href="https://www.jasondavies.com/privacy/">Privacy Policy</a>. The generated word clouds may be used for any purpose.

</p></form>


    </div>
  </div>
@endsection

@section('javascript')

    <script defer src="{{ asset('js/fa/fontawesome-free/js/brands.js') }}"></script>
    <script defer src="{{ asset('js/fa/fontawesome-free/js/solid.js') }}"></script>
    <script defer src="{{ asset('js/fa/fontawesome-free/js/fontawesome.js') }}"></script>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script src="{{ asset('js/jquery.maskedinput.js') }}"></script>
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="{{ asset('js/daterangepicker.js') }}"></script>
    <script src="{{ asset('js/advanced-forms.js') }}"></script>

    <script src="{{ asset('js/dev/multiple-select.js') }}"></script>

    <script src="{{ asset('js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/datatables.js') }}"></script>

    <script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.colVis.min.js"></script>

    <script src="{{ asset('js/dev/d3.min.js') }}"></script>
    <script src="{{ asset('js/dev/cloud.min.js') }}"></script> 
@endsection