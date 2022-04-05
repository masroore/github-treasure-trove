@extends('backEnd.master')
@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="white_box_50px box_shadow_white">

                        <div class="row">

                            <div class="col-md-6">
                                <table class="table">

                                  <tbody>
                                    <tr>
                                      <th scope="col">Varient Name :</th>
                                      <td>{{ $variant->name }}</td>

                                    </tr>
                                    <tr>
                                      <th scope="col">Description :</th>
                                      <td>{{ $variant->description }}</td>
                                    </tr>
                                    <tr>
                                       <th scope="col">Values : </th>
                                      <td>{{ implode(", ", $values) }}</td>
                                    </tr>
                                  </tbody>
                                </table>
                                
                            </div>



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
