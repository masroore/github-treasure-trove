
                 <div class="card mt-5" style="width: 23rem; background:#FFFFFF;">
                    <div class="   card-body">
                        <h6> <strong class="fuente"> Categorias </strong></h6>
                        <hr class="hr">
                        @foreach ( $categorias as $categories )
                        <div class="form-check col-12 ">
                            <input class="form-check-input" type="checkbox" value="{{$categories->id}}"id="flexCheckDefault">
                            <label class="form-check-label mb-2"for="flexCheckDefault" style="">
                                <a class="s " href="{{ route('categorias.show', ['Categories' => $categories->id ]) }}">
                            <strong>  {{ ucfirst($categories->categories_name) }}</strong>
                                </a>

                            </label>
                        </div>
                        @endforeach
                        <div class="form-check col-12 ">
                            <input class="form-check-input" type="checkbox" value="{{$categories->id}}"id="flexCheckDefault">
                            <label class="form-check-label mb-2"for="flexCheckDefault" style="">
                                <a class="s " href="#">
                            <strong> MAS VENDIDOS</strong>
                                </a>

                            </label>
                        </div>
                            </label>
                        <h6><strong> Precio </strong><h6>
                            <hr class="hr">
                            <div class="slidecontainer">
                                <input type="range" min="1" max="100" value="100" class="slider" id="myRange">
                            </div>
                            <div>
                                <h6 class="text-center text-dark  "><strong> $0-$3000 </strong></h6>
                           </div>
                    </div>
                  </div>


