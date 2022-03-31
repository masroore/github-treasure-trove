
    @php
        $firstGroup = '';
    @endphp

@if(isset($product->groups) && !empty($product->groups))
    @php
        $firstGroup = (isset($product->groups[0]) && (isset($product->groups[0]->group_id))) ? $product->groups[0]->group_id : '';
    @endphp
@endif

<div class="col-md-12">
    <div class="col-md-7">
        <div class="row">
            <div class="col-md-9">
                <label for="option">Group Name</label>
                <select name="groups[]" class="form-control js-dropdown-select2" id="group_div_11111">
                    <option value="">Select Group</option>
                    @foreach ($groups as $group)
                        <option value="{{ $group->id }}" {{(isset($firstGroup) && $firstGroup==$group->id) ? 'selected' : ''}} >{{ $group->group_name }}</option>
                    @endforeach
                </select>
            </div>   
             <div class="col-md-3">
                <label for="option " class="rows"></label>
                <button type="button" class="btn btn-success" onclick="addRow()">+</button>
                <button type='button' class='btn btn-info' onclick='showDetails("<?php echo 'div_11111';?>")'>info</button>
             </div>
            
        </div>

        <div id="other_divs">
            @if(isset($product->groups) && !empty($product->groups))
                    @php
                        $i = 0;
                    @endphp

                @foreach($product->groups as $addedGroup)
                    @php

                        $idunique = 'div_'.rand(10000,50000);
                    @endphp

                    @if($i > 0)
                        <div class="row morediv" id="{{$idunique}}">
                            <br>
                            <div class="col-md-9">
                                <label class="option">Group Name</label>
                                <select class="form-control js-dropdown-select2" id="group_{{$idunique}}" type="number" name="groups[]">
                                    <option value="">Select Group</option>
                                    @foreach ($groups as $group)
                                        <option {{(isset($addedGroup->group_id) && $addedGroup->group_id==$group->id) ? 'selected' : ''}} value="{{ $group->id }}">{{ $group->group_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="option " class="rows"></label>
                                <button type='button' class='btn btn-danger' onclick='removeWithNum("{{$idunique}}")'>-</button>
                                <button type='button' title="View Selected Group Details" class='btn btn-info' onclick='showDetails("{{$idunique}}")'>info</button>
                            </div>
                           
                        </div>
                    @endif    
                    @php
                        $i++;
                    @endphp

                @endforeach
            @endif
        </div>
    </div>
    <div class="col-md-5">
        <div class="card card-info" id="group_data_info" style="display:none">         
          <div class="card-body">
            <h3 id="group_label"></h3>
            <div class="row">
                <table style="width:100%" id="group_details_table" class="table-responsive table">
                    <thead>
                        <tr>
                            <th>Package</th>
                            <th>Zip Code</th>
                            <th>Delivery Time</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody id="prices_body">
                    </tbody>
                </table>
                         
            </div>
          </div>
        
        </div>
    </div>
</div>

<style type="text/css">
    label.rows {
    height: 15px;
}
</style>

      